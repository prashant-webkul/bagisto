<?php

namespace Webkul\SAASCustomizer\Http\Controllers;

use Webkul\SAASCustomizer\Http\Controllers\Controller;

/**
 * Super User controller
 *
 * @author Prashant Singh <prashant.singh852@webkul.com> @prashant-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class SuperUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:super-admin', ['only' => ['list', 'account']]);
    }

    /**
     * To show the login screen
     */
    public function index()
    {
        if (! auth()->guard('super-admin')->check()) {
            return view('saas::companies.auth.login');
        } else {
            return redirect()->route('super.session.index');
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! auth()->guard('super-admin')->attempt(request(['email', 'password']))) {
            session()->flash('error', trans('admin::app.users.users.login-error'));

            return redirect()->route('super.session.index');
        }

        session()->flash('success', 'Logged in successfully');

        return redirect()->route('super.companies.index');
    }

    public function list()
    {
        return view('saas::companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        auth()->guard('super-admin')->logout();

        return redirect()->route('super.session.index');
    }

    /**
     * To load super admin account management screen
     *
     * @return View
     */
    public function account()
    {
        $superAdmin = auth()->guard('super-admin')->user();

        return view('saas::companies.account')->with('super', $superAdmin);
    }

    /**
     * To update the details of super admin
     *
     * @return Redirect
     */
    public function update()
    {
        $data = request()->all();

        $req = \Validator::make($data, [
            'email' => 'required|email',
            'logo.*' => 'mimes:jpeg,jpg,bmp,png',
            'favicon.*' => 'mimes:jpeg,jpg,bmp,png',
            'old_password' => 'required|string|min:6',
            'password'=> 'nullable|min:6',
            'password_confirmation' => 'nullable|required_with:password|same:password'
        ]);

        $superAdmin = auth()->guard('super-admin')->user();

        $hashCheck = \Hash::check($data['old_password'], $superAdmin->password);

        $passwordUpdated = false;

        if ($hashCheck) {
            if ((isset($data['password']) && $data['password'] != "") && (isset($data['password_confirmation']) && $data['password_confirmation'] != "")) {
                $superAdmin->update([
                    'password' => bcrypt($data['password'])
                ]);

                $passwordUpdated = true;
            }

            $pathLogo = $pathFav = null;

            if (isset($data['logo']) && array_first($data['logo']) != "") {
                $pathLogo = $this->uploadImage($data);

                $image['logo'] = $pathLogo;
            }

            if (isset($data['favicon']) && array_first($data['favicon']) != "") {
                $pathFav = $this->uploadImage($data);

                $image['favicon'] = $pathFav;
            }

            if (! isset($pathLogo)) {
                if (isset($superAdmin->misc)) {
                    $images = json_decode($superAdmin->misc);

                    if (isset($images->logo)) {
                        $image['logo'] = $images->logo;
                    } else {
                        $image['logo'] = null;
                    }
                }
            }

            if (! isset($pathFav)) {
                if (isset($superAdmin->misc)) {
                    $images = json_decode($superAdmin->misc);

                    if (isset($images->favicon)) {
                        $image['favicon'] = $images->favicon;
                    } else {
                        $image['favicon'] = null;
                    }
                }
            }

            if (isset($images)) {
                $superAdmin->update([
                    'misc' => json_encode($image)
                ]);
            }

            session()->flash('success', trans('saas::app.account.account-updated'));
        } else {
            session()->flash('warning', trans('saas::app.account.pass-check-fail'));
        }

        if ($passwordUpdated) {
            return redirect()->route('super.session.index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * @param array $data
     * @param mixed $channel
     * @return void
     */
    public function uploadImage($data)
    {
        $dir = 'su';

        if (isset($data['logo'])) {
            $image = array_first($data['logo'], function ($value) {
                if ($value)
                    return $value;
                else
                    return false;
            });

            if ($image != false) {
                $uploaded = $image->store($dir.$image);

                unset($data['image'], $data['_token']);

                return $uploaded;
            }
        }

        if (isset($data['favicon'])) {
            $image = array_first($data['favicon'], function ($value) {
                if ($value)
                    return $value;
                else
                    return false;
            });

            if ($image != false) {
                $uploaded = $image->store($dir.$image);

                unset($data['image'], $data['_token']);

                return $uploaded;
            }
        }

        return null;
    }
}