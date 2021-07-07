<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\UserRepository;
use App\Services\RobokassaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RobokassaController extends Controller
{

    private $OutSum = 0;
    private $robokassaService;

    public function __construct(RobokassaService $robokassaService)
    {

        $this->robokassaService = $robokassaService;
    }

    public function successURL(Request $request)
    {
        if ($request->Shp_device == 0) {
            $templateName = 'site.pages.account.payment_success';
            return $this->viewPage($templateName);
        } else {
            return redirect();
        }
    }

    public function failUrl(Request $request)
    {
        $templateName = 'site.pages.account.payment_fail';
        $this->robokassaService->fail($request);
        return $this->viewPage($templateName);
    }

    public function resultURL(Request $request)
    {
        try {
            $result = $this->robokassaService->checkData($request);
            $result->user()->update(['account_paid_at', Carbon::now()]);
            return "ОК$result->transaction_id";
        } catch (\Exception $e) {
            return "error";
        }
    }


    public function payment(Request $request)
    {
        $templateName = 'site.pages.account.payment';
        return $this->viewPage($templateName);
    }

    public function viewPage($templateName)
    {
        $user = auth()->user();
        if (!$user) {
            abort(403);
        }

        $url = $this->robokassaService->collectData($user);

        if ($user->hasRole('contractor')) {
            $accountPage = 'personal';
            return view($templateName, compact('user', 'accountPage', 'url'));
        } elseif ($user->hasRole('customer')) {
            if ($user->customer_type == 'legal_entity') {
                $accountPage = 'company';
            } else {
                $accountPage = 'personal';
            }
            return view($templateName, compact('user', 'accountPage', 'url'));
        } else {
            abort(403);
        }
    }
}
