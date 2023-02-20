<?php

namespace App\Http\Controllers;

use App\Services\VetmanagerApi;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function index()
    {
        $clients = (new VetmanagerApi(auth()->user()))->getAll(VetmanagerApi::CLIENT);
        return view('dashboard', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();
        (new VetmanagerApi(auth()->user()))->create(VetmanagerApi::CLIENT, $validated);
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function show(int $id)
    {
        $client = (new VetmanagerApi(auth()->user()))->getOne(VetmanagerApi::CLIENT, $id);
        $pets = (new VetmanagerApi(auth()->user()))->getPetsByClientId($id);
        return view('clients.show', ['client' => $client, 'pets' => $pets]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function edit(int $id)
    {
        $infoClient = (new VetmanagerApi(auth()->user()))->getOne(VetmanagerApi::CLIENT, $id);
        return view('clients.edit', ['infoClient' => $infoClient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function update(ClientRequest $request, int $id)
    {
        $validated = $request->validated();
        (new VetmanagerApi(auth()->user()))->edit(VetmanagerApi::CLIENT, $validated, $id);
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function destroy(int $id)
    {
        (new VetmanagerApi(auth()->user()))->delete(VetmanagerApi::CLIENT, $id);
        return redirect('/dashboard');
    }

    // Поисковик

    /**
     * @throws GuzzleException
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $searchClient = (new VetmanagerApi(auth()->user()))->searchClient($query);
        return view('clients.search', ['searchClient' => $searchClient]);
    }
}
