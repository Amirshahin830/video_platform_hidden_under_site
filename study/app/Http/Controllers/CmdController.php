<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class CmdController extends Controller
{
    public function shutdown()
    {
        Process::run('sudo /usr/sbin/shutdown -h now');
        return abort(503);
    }

    public function reboot()
    {
        Process::run('sudo /usr/sbin/reboot');
        return abort(503);
    }

}
