<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $paginator = Address::paginate($perPage = 25);
        return view('admin.mail.address', [
            'paginator' => $paginator
        ]);
    }

    public function set(Request $request)
    {
        $state = $request->state;
        $address = Address::where('address', $request->address)
            ->update([
                'state' => $state
            ]);
        $this->index();
        return $state;
    }
}
