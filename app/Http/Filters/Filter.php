<?php

namespace App\Http\Filters;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\Action;
use App\Models\Permission;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\Redirect;

/**
 * Routefilter
 *
 * @package Onvard\Filter\Filters
 */
class Filter
{

    /**
     * Invalidate the Browser Cache
     * Helpful Filter to tell the Browser to dump the Site's Cache.
     * For Example: If a User logs out and hits the 'back' Button of his Browser, he doesn't get served a cached copy.
     */
    public function invalidateBrowserCache() {
        $this->response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
        $this->response->headers->set('Pragma','no-cache');
        $this->response->headers->set('Expires','Fri, 01 Jan 1970 00:00:00 GMT');
    }

    /**
     * Minify the HTML Output
     *
     * @see http://laravel-tricks.com/tricks/minify-html-output
     */
    public function minifyHTML(){
        $buffer = $this->response->getContent();
        if(strpos($buffer,'<pre>') !== false)
        {
            $replace = array(
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/"                  => '<?php ',
                "/\r/"                      => '',
                "/>\n</"                    => '><',
                "/>\s+\n</"    				=> '><',
                "/>\n\s+</"					=> '><',
            );
        }
        else
        {
            $replace = array(
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/"                  => '<?php ',
                "/\n([\S])/"                => '$1',
                "/\r/"                      => '',
                "/\n/"                      => '',
                "/\t/"                      => '',
                "/ +/"                      => ' ',
                '#^\s*//.+$#m'              => '', // remove single comment in JS
            );
        }
        $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);
        $this->response->setContent($buffer);
    }

    /**
     * controle de acesso
     * @return [type] [description]
     */
    public function acl($RouteName)
    {
        if (Auth::check())
        {
            if (Auth::id()) {
                return true;
            }

            $TypePolice = env('APP_POLICE');
            if ($TypePolice == "SESSION") {
                $s = session('P');
                $p = $this->hashPolice($RouteName);
                if (!isset($s[$p]) || !$s[$p]) {
                    abort(403, 'Sem permissão!');
                }

            } else if ($TypePolice == "DB") {
                $ObjAction = Action::where('name', $RouteName)->first();
                if ($ObjAction) {
                    $ObjUser = User::where('id', Auth::id())->first();

                    if ($ObjUser && $ObjUser->active) {
                        foreach ($ObjUser->roles as $role) {
                            if (isset($role->id) && $role->id > 0) {
                                $roles[$role->id] = $role->id;
                            }
                        }

                        if (is_array($roles) && count($roles) > 0) {
                            $ObjPermissionRole = Permission::where('action_id', $ObjAction->id)
                                ->whereIn('role_id', $roles)
                                ->first();
                        }

                        $PermissionRetun = FALSE;

                        if ($ObjPermissionRole) {
                            if ($ObjPermissionRole->permission) {
                                $PermissionRetun = TRUE;
                            }
                        }

                        #permissao de usuario | deve sobrepor a do grupo
                        $ObjPermission = Permission::where('action_id', $ObjAction->id)
                            ->where('user_id', Auth::id())
                            ->first();

                        if ($ObjPermission) {
                            if ($ObjPermission->permission) {
                                $PermissionRetun = TRUE;
                            } else {
                                $PermissionRetun = FALSE;
                            }
                        }

                        #result
                        if (!$PermissionRetun) {
                            abort(403, 'Sem permissão!');
                        }
                    } else {
                        abort(403, 'Usuário Inativo!');
                    }
                } else {
                    abort(403, 'Rota não definida!');
                }

            } else {
                abort(403, 'Politica de acesso não Definida!');
            }
        }
        else
        {
            return Redirect::route('auth.loginGet');
        }
    }

    public function translator()
    {
        $locale = session('locale');
        App::setLocale($locale);
    }

    protected function hashPolice($string)
    {
        #este metodo deve ser clonado em Filters
        $custo = '08';
        $salt = 'Cf1f11ePArKlBJomM0F6aL';
        return crypt($string, '$2a$' . $custo . '$' . $salt . '$');
    }
}