<?php
namespace Azuriom\Plugin\Referral\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Azuriom\Plugin\Shop\Models\Package;
use Azuriom\Plugin\Referral\Models\ReferralPackagesLinks;

class AdminPackagesController extends Controller
{
    public function index()
    {
        $items = Package::all();
        $links = ReferralPackagesLinks::all();

        return view('referral::admin.packages-links', compact('items', 'links'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'amounts' => ['required', 'array'],
            'amounts.*' => ['numeric', 'min:0'],
        ]);

        $amounts = $request->input('amounts');

        foreach($amounts as $itemId => $amount) {
            ReferralPackagesLinks::updateOrCreate(
                ['shop_package_id' => $itemId],
                ['applied_amount' => $amount]
            );
        }

        return redirect()->route('referral.admin.links')
                         ->with('success', trans('referral::messages.admin.links-saved'));
    }
}
