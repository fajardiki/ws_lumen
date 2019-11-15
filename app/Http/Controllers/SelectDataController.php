<?php 

namespace App\Http\Controllers;

use App\Models\AuthSesModel;
use App\Models\AuthTenModel;
use App\Models\BridgeLogModel;
use App\Models\BridgeSesModel;

class SelectDataController extends Controller {
	
	public function authsession() {
		$authses = AuthSesModel::all();
		return response()->json([
			'Auth_Session' => $authses
		]);
	}

	public function authtenant() {
		$authten = AuthTenModel::all();
		return response()->json([
			'Auth_Tenant' => $authten
		]);
	}

	public function bridgelog()	{
		$bridgelog = BridgeLogModel::all();
		return response()->json([
			'Bridge_Log' => $bridgelog
		]);
	}

	public function bridgesession()	{
			$bridgeses = BridgeSesModel::all();
			return response()->json([
				'Bridge_Session' => $bridgeses
			]);
		}
}
?>