<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigurationFormRequest;
use App\Models\Configuration;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): View
    {
        $conf = Configuration::first();
        return view('configuration.edit')->with('conf', $conf);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConfigurationFormRequest $request, Configuration $conf): RedirectResponse
    {
        $validatedData = $request->validated();
        DB::transaction(function () use ($validatedData, $conf) {
            $conf->ticket_price = $validatedData['ticket_price'];
            $conf->registered_customer_ticket_discount = $validatedData['registered_customer_ticket_discount'];
            $conf->save();
            return $conf;
        });
        return redirect()->back();
    }
}
