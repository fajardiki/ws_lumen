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
	public function bridgelog($limit)	{

		$time_start = microtime(true);
		
		$bridgelog = BridgeLogModel::limit($limit)->get();
		// $bridgelog = BridgeLogModel::all();

		$time_end = microtime(true);
		$execution_time = $time_end - $time_start;

		return response()->json([
			'Bridge_Log' => $bridgelog,
			'time' => $execution_time
		]);
	}
	
	// SEARCH DATA
	public function search($cari) {
		$time_start = microtime(true);

		$search = BridgeLogModel::where('msisdn',$cari)->get();

		$time_end = microtime(true);
		$execution_time = $time_end - $time_start;

		return response()->json([
			'Bridge_Log' => $search,
			'time' => $execution_time
		]);
	}

	// UPDATE DATA
	public function update(Request $request) {
		$time_start = microtime(true);

		$jmlupdate = $request->input('jumlahupdate');
		$msisdn = $request->input('msisdn');
		$called = $request->input('called');
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$area = $request->input('area');
		$ts = $request->input('ts');
		$tenant = $request->input('tenant');

		$id = BridgeLogModel::max('id');

		$lastid = $id;
		$maxulang = $lastid-$jmlupdate;

		for ($i=$lastid; $i > $maxulang; $i--) {
			$update = BridgeLogModel::where('id', $i)->update(['msisdn'=>$msisdn, 'called'=>$called, 'lat'=>$lat, 'lng'=>$lng, 'area'=>$area, 'ts'=>$ts, 'tenant'=>$tenant]);
		}

		$time_end = microtime(true);
		$execution_time = $time_end - $time_start;

		if ($update) {
			return response()->json([
				'message' => 'Updated Success',
				'time' => $execution_time
			]);
		} else {
			return response()->json([
				'message' => 'Updated Failed',
				'time' => $execution_time
			]);
		}
	}

	// INSERT DATA
	public function insert(Request $request) {

		$time_start = microtime(true);

		$msisdn = $request->input('msisdn');
		$called = $request->input('called');
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$area = $request->input('area');
		$ts = $request->input('ts');
		$tenant = $request->input('tenant');
		$jmlinput = (int)$request->input('jumlahinsert');

		$id = BridgeLogModel::max('id');

		$lastid = $id+1;
		$maxulang = $lastid+$jmlinput;

		for ($i=$lastid; $i < $maxulang; $i++) { 
			$insert = BridgeLogModel::insert(['id'=>$i, 'msisdn'=>$msisdn, 'called'=>$called, 'lat'=>$lat, 'lng'=>$lng, 'area'=>$area, 'ts'=>$ts, 'tenant'=>$tenant]);
		}

		$time_end = microtime(true);
		$execution_time = $time_end - $time_start;

		if ($insert) {
			return response()->json([
				'message' => 'Updated Success',
				'time' => $execution_time
			]);
		} else {
			return response()->json([
				'message' => 'Updated Failed',
				'time' => $execution_time
			]);
		}

		// return response()->json(['id'=>$id]);
	}

	// DELETE DATA
	public function delete($jmldel) {
		$time_start = microtime(true);
		$id = BridgeLogModel::max('id');
		$jml = (int)$jmldel;

		$lastid = $id;
		$maxulang = $lastid-$jml;

		for ($i=$lastid; $i > $maxulang; $i--) { 
			$delete = BridgeLogModel::where('id',$i)->delete();
		}

		$time_end = microtime(true);
		$execution_time = $time_end - $time_start;	

		if ($delete) {
			return response()->json([
				'message' => 'Delete Success',
				'time' => $execution_time
			]);
		} else {
			return response()->json([
				'message' => 'Delete Failed',
				'time' => $execution_time
			]);
		}
	}
}

// php -S localhost:6060 -t public
?>