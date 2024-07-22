<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Auth;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = Auth::user()->id ??'';
        $userAgent= DB::table('users')->select('user_agent')->where('id', $userId)->first();
        $br= $this->getBrowser();
       // dd($userAgent);
        if($userAgent !=null && $userAgent->user_agent == $br['name']){
            return $next($request);
        }else{
            return redirect('logout')->with('error','Your session is not authorized!');
        }

    }
    function getBrowser() {
      $u_agent = $_SERVER['HTTP_USER_AGENT'];
      $bname = 'Unknown';
      $platform = 'Unknown';
      $version= "";
  
      // First get the platform?
      if (preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
      } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
      } elseif (preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
      }
  
      // Next get the name of the useragent yes separately and for good reason
      if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
      } elseif (preg_match('/Firefox/i', $u_agent)) {
          $bname = 'Mozilla Firefox';
          $ub = "Firefox";
      } elseif (preg_match('/OPR|Opera/i', $u_agent)) {
          $bname = 'Opera';
          $ub = "Opera";
      } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
          $bname = 'Google Chrome';
          $ub = "Chrome";
      } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
          $bname = 'Apple Safari';
          $ub = "Safari";
      } elseif (preg_match('/Netscape/i', $u_agent)) {
          $bname = 'Netscape';
          $ub = "Netscape";
      } elseif (preg_match('/Edge/i', $u_agent)) {
          $bname = 'Edge';
          $ub = "Edge";
      } elseif (preg_match('/Trident/i', $u_agent)) {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
      }
  
      // Finally get the correct version number
      $known = array('Version', $ub, 'other');
      $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
      if (!preg_match_all($pattern, $u_agent, $matches)) {
          // we have no matching number just continue
      }
      // See how many we have
      $i = count($matches['browser']);
      if ($i != 1) {
          // We will have two since we are not using 'other' argument yet
          // See if version is before or after the name
          if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
              $version = $matches['version'][0];
          } else {
              if(count($matches['version'])>0){
                $version = $matches['version'][1];
              }
          }
      } else {
          $version = $matches['version'][0];
      }
  
      // Check if we have a number
      if ($version == null || $version == "") {
          $version = "?";
      }
  
      return array(
          'userAgent' => $u_agent,
          'name'      => $bname,
          'version'   => $version,
          'platform'  => $platform,
          'pattern'   => $pattern
      );
  }
}
