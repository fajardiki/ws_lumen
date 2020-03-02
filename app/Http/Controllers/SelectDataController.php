<?php 

namespace App\Http\Controllers;

use App\Models\AuthSesModel;
use App\Models\AuthTenModel;
use App\Models\BridgeLogModel;
use App\Models\BridgeSesModel;

use Illuminate\Http\Request;

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

	public function bridgesession()	{
		$bridgeses = BridgeSesModel::all();
		return response()->json([
			'Bridge_Session' => $bridgeses
		]);
	}

	// SELECT DATA
	public function bridgelog()	{

		$time_start = microtime(true);
		
		$bridgelog = BridgeLogModel::limit(1000)->get();
		// $bridgelog = BridgeLogModel::all();

		$time_end = microtime(true);

		$execution_time = $time_end - $time_start;

		$result = number_format($execution_time,3);

		return response()->json([
			'Bridge_Log' => $bridgelog,
			'Time' => $execution_time
		]);
	}
	
	// SEARCH DATA
	public function search($cari) {
		$time_start = microtime(true);

		$search = BridgeLogModel::where('msisdn',$cari)->get();

		$time_end = microtime(true);

		$execution_time = $time_end - $time_start;

		$result = number_format($execution_time,3);

		return response()->json([
			'Bridge_Session' => $search,
			'Time' => $execution_time
		]);
	}

	// UPDATE DATA
	public function update(Request $request) {
		$id = $request->input('id');

		$msisdn = $request->input('msisdn');
		$called = $request->input('called');
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$area = $request->input('area');
		$ts = $request->input('ts');
		$tenant = $request->input('tenant');

		$update = BridgeLogModel::where('id', $id)->update(['msisdn'=>$msisdn, 'called'=>$called, 'lat'=>$lat, 'lng'=>$lng, 'area'=>$area, 'ts'=>$ts, 'tenant'=>$tenant]);

		if ($update) {
			return response()->json([
				'message' => 'Updated Success'
			]);
		} else {
			return response()->json([
				'message' => 'Updated Failed'
			]);
		}
	}

	// INSERT DATA
	public function insert(Request $request) {

		$msisdn = $request->input('msisdn');
		$called = $request->input('called');
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$area = $request->input('area');
		$ts = $request->input('ts');
		$tenant = $request->input('tenant');

		$id = BridgeLogModel::max('id');

		$lastid = $id+1;

		$insert = BridgeLogModel::insert(['id'=>$lastid, 'msisdn'=>$msisdn, 'called'=>$called, 'lat'=>$lat, 'lng'=>$lng, 'area'=>$area, 'ts'=>$ts, 'tenant'=>$tenant]);

		if ($insert) {
			return response()->json([
				'message' => 'Updated Success'
			]);
		} else {
			return response()->json([
				'message' => 'Updated Failed'
			]);
		}

		// return response()->json(['id'=>$id]);
	}

	// DELETE DATA
	public function delete($id) {

		$delete = BridgeLogModel::where('id',$id)->delete();

		if ($delete) {
			return response()->json([
				'message' => 'Delete Success'
			]);
		} else {
			return response()->json([
				'message' => 'Delete Failed'
			]);
		}
	}
}

// php -S localhost:6060 -t public
?>