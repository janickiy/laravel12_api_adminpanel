<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Requests\Admin\Admin\StoreRequest;
use App\Http\Requests\Admin\Admin\EditRequest;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.index')->with('title', 'Пользователи');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('admin.create_edit', compact('options'))->with('title', 'Добавить пользователя');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Admin::create(array_merge($request->all(), ['password' => Hash::make($request->password)]));

        return redirect()->route('admin.index')->with('success', 'Информация успешно добавлена!');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Admin::find($id);

        if (!$row) abort(404);

        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('admin.create_edit', compact('row', 'options'))->with('title', 'Редактировать пользователя');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $admin = Admin::find($request->id);

        if (!$admin) abort(404);

        $admin->login = $request->input('login');
        $admin->name = $request->input('name');

        if (!empty($request->role)) $admin->role = $request->input('role');

        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Данные успешно обновлены!');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        if ($request->id !== Auth::id()) Admin::find($request->id)->delete();
    }
}
