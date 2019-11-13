<?php 

namespace App\Http\Controllers;

use App\Models\AuthSesModel;
use App\Models\AuthTenModel;
// use App\Models\BridgeLogModel;

class SelectDataController extends Controller {
	
	public function index()	{
		$authses = AuthSesModel::all();
		$authten = AuthTenModel::all();
		// $bridgelog = BridgeLogModel::all();
		return response()->json([
			'Auth_Session' => $authses,
			'Auth_Tenant' => $authten
		]);
	}

}
?>