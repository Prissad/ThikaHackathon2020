<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Client;
use App\ClientDetails;
use App\Notifications\SignupActivate;
use App\Repositories\ClientRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ClientController extends CrudController
{

    /**
     * ClientController constructor.
     * @param ClientRepository $clientRepository
     */

    public function __construct(ClientRepository $clientRepository)
    {
        $relations = ['role','clientDetails.classe.subjects','clientDetails.subscription','clientDetails.classe.live'];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($clientRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
    /**
     * Create client
     *
     * @param  [string] fname
     * @param  [string] lname
     * @param  [string] phone
     * @param  [string] birthday
     * @param  [string] grade
     * @param  [string] establishment
     * @param  [string] region
     * @param  [string] email
     * @param  [string] password
     * @param  [string] classe_id
     * @param  [string] password_confirmation
     * @return [string] message
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if ($request->fname == '') {
            return response()->json([
                'error' => 'le champ fname  est obligatoire !'
            ], 403);
        }
        if ($request->lname == '') {
            return response()->json([
                'error' => 'le champ lname  est obligatoire !'
            ], 403);
        }
        if ($request->email == '') {
            return response()->json([
                'error' => 'le champ email  est obligatoire !'
            ], 403);
        }
        $this->validate($request, [
            'password' => 'required|confirmed|min:8',
        ]);

        if ($request->grade == '') {
            return response()->json([
                'error' => 'le champ grade  est obligatoire !'
            ], 403);
        }



        $client = new Client([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'activation_token' => Str::random(60),

        ]);
        $clientDetails = [
            'region' => $request->region,
            'birthday' => $request->birthday,
            'establishment' => $request->establishment,
            'grade' => $request->grade
        ];
        /*$classe = [
            'name' => $request->name,
        ];*/
        $classe_model = Classe::where('id', $request->classe_id)->first();

        DB::beginTransaction(); //Start transaction!

        try {
            //saving logic here
            $client->save();
            //$classe_model = Classe::create($classe);
            $client_details = ClientDetails::create($clientDetails);
            $client_details->classe()->associate($classe_model);
            $client->clientDetails()->save($client_details);
            $client->notify(new SignupActivate($client));
            //$client->clientDetails()->classe()->associate($classe);
            DB::commit();
            return response()->json([
                'message' => 'Successfully created user! please visit your email to activate your account'
            ], 201);
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;

        }
        }

    /**
     * Update client
     *
     * @param  [string] fname
     * @param  [string] lname
     * @param  [string] phone
     * @param  [string] birthday
     * @param  [string] grade
     * @param  [string] establishment
     * @param  [string] region
     * @param  [string] classe_id
     * @return [string] message
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        // findt the client
        $client = Client::where('id', $id)->first();
        $validatedData = $request->validate([
            'fname' => 'nullable|string',
            'lname' => 'nullable|string',
            'phone' => 'nullable|string',
            'birthday' => 'nullable|string',
            'grade' => 'nullable|string',
            'establishment' => 'nullable|string',
            'region' => 'nullable|string',
            'classe_id' =>'nullable|string'
        ]);
        $filtred_data = array_filter($validatedData);

        if ( isset($filtred_data['classe_id'] ))
        {
            $client_details = $client->clientDetails;
            $client_details->classe()->dissociate();
            $classe_model = Classe::where('id', $request->classe_id)->first();
            $client_details->classe()->associate($classe_model);
            $client->clientDetails()->save($client_details);

        }

            $client_details = $client->clientDetails;
            $client_details->update($filtred_data);
            $client_details->save();


        $client->update($filtred_data);
        $client->save();
        return $client;
    }
    /**
     * Get clients wich are subscribed
     */
    public function getSubscribedClients(Request $request)
    {
        $clients = Client::all();
        $collection = collect ();
        foreach ($clients as $client)
        {
            if (  $client->clientDetails->subscription->name == "Silver" || $client->clientDetails->subscription->name == "Gold")
                $collection->push($client);
        }
        return $collection->paginate(5);
    }
    /**
     * Get count clients
     */
    public function getCountClients()
    {
        $userCount = User::count();
        $clients = Client::all();
        $subscried = [];
        foreach ($clients as $client)
        {
            if (  $client->clientDetails->subscription->name == "Silver" || $client->clientDetails->subscription->name == "Gold")
                array_push($subscried,$client);
        }
        return (response()->json([
            "users" => $userCount,
            "subscribed" => count ($subscried)
        ],201));
    }
    /**
     * Get count clients
     */
    public function getFiftyClients()
    {
        return  (DB::table('users')
            ->join('client_details', 'users.id', '=', 'client_details.client_id')
            ->join('classes', 'classes.id', '=', 'client_details.classe_id')
            ->join('subscriptions', 'subscriptions.id', '=', 'client_details.subscription_id')
            ->having('subscriptions.name','!=','Free')
            ->select(
                'users.fname as first_name',
                'users.lname as last_name',
                'users.email',
                'subscriptions.name AS subscription'  ,
                'client_details.grade',
                'classes.name AS classe'

            )
            ->take(50)
            ->get());
    }
    public function getAllSubscribed()
    {

        $clients = Client::all();
        $collection = collect ();

        foreach ($clients as $client)
        {
            if ((  $client->clientDetails->subscription->name == "Silver" ||
                $client->clientDetails->subscription->name == "Gold")
                && ($client->clientDetails->classe->name) )
                $collection->push($client);
        }

        return $collection->all();
    }

}
