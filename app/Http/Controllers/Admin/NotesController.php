<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\NoteRepository;
use App\Http\Requests\Admin\Notes\EditRequest;
use App\Http\Requests\Admin\Notes\DeleteRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;


class NotesController extends Controller
{
    public function __construct(
        private NoteRepository $noteRepository,
    )
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.notes.index')->with('title', 'Заметки');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->noteRepository->find($id);

        if (!$row) abort(404);

        return view('admin.notes.create_edit', compact('row'))->with('title', 'Редактирование');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->noteRepository->update($request->id, $request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.notes.index')->with('success', 'Данные обновлены успешно');
    }
    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->noteRepository->delete($request->id);;
    }
}
