<?php 

namespace App\Http\Controllers;

use App\Models\AuthSesModel;
use App\Models\AuthTenModel;
use App\Models\BridgeLogModel;
use App\Models\BridgeSesModel;

use Illuminate\Http\Request;

class SelectDataController extends Controller {
	

	// SELECT DATA
	public function select($limit)	{

		$this->startTimer();

		for ($i=1; $i <= $limit ; $i++) { 
			$bridgelog = BridgeLogModel::where('id',$i)->get();

			foreach ($bridgelog as $dtat) {
				$item[] = array(
					"id"=>$dtat->id,
					"msisdn"=>$dtat->msisdn,
					"called"=>$dtat->called,
					"lat"=>$dtat->lat,
					"lng"=>$dtat->lng,
					"area"=>$dtat->area,
					"ts"=>$dtat->ts,
					"tenant"=>$dtat->tenant
				);
			}
		}

		return response()->json([
			'result'=>'succes',
			'Bridge_Log'=>$item,
			'request'=>$i,
			'time'=>$this->endTimer()." Second",
			'memory'=>$this->memory().' MB',
			'cpu'=>$this->get_cpu_usage()."%"	
		]);
	}
	
	// SEARCH DATA
	public function search($cari) {
		$this->startTimer();

		$search = BridgeLogModel::where('msisdn',$cari)->get();

		return response()->json([
			'result'=>'succes',
			'Bridge_Log'=>$search,
			'time'=>$this->endTimer()." Second",
			'memory'=>$this->memory().' MB',
			'cpu'=>$this->get_cpu_usage()."%"
		]);
	}

	// UPDATE DATA
	public function update(Request $request) {
		$this->startTimer();

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

		if ($update) {
			return response()->json([
				'result'=>'succes',
				'request'=>$i,
				'time'=>$this->endTimer()." Second",
				'memory'=>$this->memory().' MB',
				'cpu'=>$this->get_cpu_usage()."%"
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

		$this->startTimer();

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

		if ($insert) {
			return response()->json([
				'result'=>'succes',
				'request'=>$i,
				'time'=>$this->endTimer()." Second",
				'memory'=>$this->memory().' MB',
				'cpu'=>$this->get_cpu_usage()."%"
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
		$this->startTimer();

		$id = BridgeLogModel::max('id');
		$jml = (int)$jmldel;

		$lastid = $id;
		$maxulang = $lastid-$jml;

		for ($i=$lastid; $i > $maxulang; $i--) { 
			$delete = BridgeLogModel::where('id',$i)->delete();
		}

		if ($delete) {
			return response()->json([
				'result'=>'succes',
				'request'=>$i,
				'time'=>$this->endTimer()." Second",
				'memory'=>$this->memory().' MB',
				'cpu'=>$this->get_cpu_usage()."%"
			]);
		} else {
			return response()->json([
				'message' => 'Delete Failed',
				'time' => $execution_time
			]);
		}
	}

	function startTimer() {
        global $starttime;
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime;
    }
    
    
    function endTimer() {
        global $starttime;
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = round(($endtime - $starttime), 4);
        return $totaltime;
	}

	function memory() {
        return round(memory_get_usage()/1048576,2);
    }
	
	function get_cpu_usage() {
        $cmd = "wmic cpu get loadpercentage";
        exec($cmd, $output, $value);

        if ($value==0) {
            return $output[1];
        } else {
            return "Cannot Get CPU Usage!";
        }
	}
	

}

// php -S localhost:6060 -t public
?>