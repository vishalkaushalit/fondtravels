<?php

namespace App\Http\Controllers;

use App\Models\GlobalScript;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GlobalScriptController extends Controller
{
    public function edit(): View
    {
        $globalScripts = GlobalScript::findCurrent() ?? new GlobalScript();

        return view('global-scripts.edit', compact('globalScripts'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'header_scripts' => ['nullable', 'string'],
            'body_scripts' => ['nullable', 'string'],
            'footer_scripts' => ['nullable', 'string'],
        ]);

        $globalScripts = GlobalScript::query()->first() ?? new GlobalScript();
        $globalScripts->fill($validated);
        $globalScripts->save();

        return redirect()->route('global-scripts.edit')->with('success', 'Global scripts updated successfully.');
    }
}
