<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientAllResource;
use App\Http\Resources\ClientBillingResource;
use App\Http\Resources\ClientDemoGraphicResource;
use App\Http\Resources\ClientDetailsResource;
use App\Http\Resources\ClientFileResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientsDetailsReferenceResource;
use App\Http\Resources\ClientSettingsResource;
use App\Http\Resources\ClientStoreResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        return ClientAllResource::collection(Client::all());
    }



    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'country_code' => 'required|string|max:3',
                'phone' => 'required|string|max:15',
                'company' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
            ]);

            $client = Client::create($validatedData);


            return response()->json(new ClientStoreResource($client), 201);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Failed to create client',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function update(Request $request, Client $id)


    {


        // Log::info('Raw request body:', ['content' => $request->getContent()]);


        // Log::info('Request input:', $request->all());

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id->id,
            'phone' => 'required|string|max:15',
            'country_code' => 'required|string|max:5',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);


        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            Log::info('File details:', [
                'originalName' => $file->getClientOriginalName(),
                'mimeType' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);

            $filename = time() . '.' . $file->getClientOriginalExtension();


            $path = $file->storeAs('images', $filename, 'public');


            $validatedData['profile_pic'] = 'storage/' . $path;
        }


        $id->update($validatedData);


        return new ClientResource($id);
    }

    public function updateDemoGraphic(Request $request, Client $id)


    {


        // Log::info('Raw request body:', ['content' => $request->getContent()]);


        // Log::info('Request input:', $request->all());

        $validatedData = $request->validate([
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:8',
            'timezone' => 'required|string',
            'address' => 'required|string|max:500',
            'language' => 'required|array',
            'language.*' => 'string',
        ]);

        $id->update($validatedData);


        return new ClientDemoGraphicResource($id);
    }

    public function updateBilling(Request $request, Client $id)


    {



        $validatedData = $request->validate([
            'bill_to' => 'required|string|max:255',
            'tax_id' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'country_code' => 'required|string|max:5',
            'billing_phone' => 'required|string|max:15',
            'billing_email' => 'required|email|unique:clients,email,' . $id->id,

        ]);

        $id->update($validatedData);


        return new ClientBillingResource($id);
    }

    public function updateDetails(Request $request, Client $id)


    {



        $validatedData = $request->validate([
            'details' => 'required|string|max:255',
            'reference' => 'required|string|max:255',

        ]);

        $id->update($validatedData);


        return new ClientsDetailsReferenceResource($id);
    }

    public function updateSettings(Request $request, Client $id)
    {
    
        $validatedData = $request->validate([
            'can_access_portal' => 'required|boolean',
            'password' => 'nullable|string|min:6',
        ]);
    
       
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password); 
        } else {
            unset($validatedData['password']); 
        }
    
        
        $id->update($validatedData);
    
       
        return new ClientSettingsResource($id);
    }
    

    public function details($id)
    {

        $client = Client::find($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return new ClientDetailsResource($client);
    }


    public function updateSharedFile(Request $request, Client $id)
    {
       
        $request->validate([
            'shared_file' => 'required|file|mimes:pdf|max:2048', 
        ]);
    
        
        $filePaths = [];
    

        if ($request->hasFile('shared_file')) {
            $file = $request->file('shared_file'); 
            $filename = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('shared_files', $filename, 'public'); 
            $filePaths[] = $path;
        }
    
        
        $existingFiles = $id->shared_files ?? [];
    
    
        $id->shared_files = array_merge($existingFiles, $filePaths);
    
        
        $id->save();
    
        
        return response()->json([
            'file_paths' => array_map(function ($filePath) {
                return Storage::url($filePath); 
            }, $id->shared_files),
        ]);
    }
    


    public function getFilePath(Client $id)
    {

        if (!$id->shared_files || empty($id->shared_files)) {
            return response()->json(['message' => 'No file found for this client'], 404);
        }


        return new ClientFileResource($id);
    }

    public function delete(Client $id)
    {
        $id->delete();
        return response()->json([
            'message' => 'Successfully deleted client'
        ], 200);
    }
}
