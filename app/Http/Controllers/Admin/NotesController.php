<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notes;
use App\Http\Requests\Admin\Notes\EditRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('notes.index')->with('title', 'Заметки');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Notes::find($id);

        if (!$row) abort(404);

        return view('notes.create_edit')->with('title', 'Редактирование');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Notes::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->content = $request->input('content');
        $row->save();

        return redirect()->route('notes.index')->with('success', 'Данные обновлены успешно');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Notes::find($request->id)->delete();
    }
}
