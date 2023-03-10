<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Services\PetApi;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    const PET = 'pet';

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create($ownerId)
    {
        return view('pets.create', ['ownerId' => $ownerId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PetRequest $request
     * @return Application|Redirector|RedirectResponse
     * @throws GuzzleException
     */
    public function store(PetRequest $request)
    {
        $validated = $request->validated();
        (new PetApi(Auth::user(), self::PET))->createPet($validated);
        return redirect("/clients/{$validated['owner_id']}");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function show(int $id)
    {
        $pet = (new PetApi(Auth::user(), self::PET))->getPet($id);
        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function edit(int $id)
    {
        $infoPet = (new PetApi(Auth::user(), self::PET))->getPet($id);
        return view('pets.edit', compact('id', 'infoPet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PetRequest $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     * @throws GuzzleException
     */
    public function update(PetRequest $request, int $id)
    {
        $validated = $request->validated();
        (new PetApi(Auth::user(), self::PET))->editPet($validated, $id);
        return redirect("pet/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function destroy(int $id)
    {
        (new PetApi(Auth::user(), self::PET))->deletePet($id);
        return back();
    }
}
