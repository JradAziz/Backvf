<?php

namespace App\Http\Controllers;
use App\Models\Jirabcp;
use App\Models\Member;
use App\Models\Team;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class JirabcpController extends Controller
{
      public function getcloseddata(Request $request){
        $this->validate($request, [
            'Assignee' => 'required|string',
        ]);
        $mem =Jirabcp::where([
            'Status' => "Closed",
            'Assignee' => $request->Assignee,
        ])->get();
     
        $x=-1;
        $actif = [];
        for ($i=0;$i<sizeof($mem);$i++)
        {
            $a=$mem[$i]->ResolutionDate;
            $date1 = $a;
            date_default_timezone_set('Africa/Johannesburg');
            $currentt=date('Y-m-d H:i:s', time());
            $diff = abs(strtotime($currentt) - strtotime($date1));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            
            if ($years==0  &&  $days<7  && $months==0)
            {   
                $x++;
                $actif[$x]=$mem[$i];
            }
        }



        return response($actif, 201);

        

    
    }
    public function getdata(Request $request){
        $this->validate($request, [
            'Status' => 'required|string',
            'Assignee' => 'required|string',
        ]);
        $mem =Jirabcp::where([
            'Status' =>  $request->Status,
            'Assignee' => $request->Assignee,
        ])->get();

        return response($mem, 201);
    
    }
    public function getuserteamid(Request $request)
    {

        $fields = $request->validate([
            'id' => 'required|string',
        ]);
        $user = Member::where('userid',$fields['id'])->get();
        $teamm=Team::Where('id',$user[0]->teamid)->get();
        $response = [
            'team id' => $user[0]->teamid,  
            'Team Name'=> $teamm[0]->Teamname,      
        ];

        return response($response, 201);

    }


    public function getuserteammates(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|string',
        ]);
        $member = Member::where('userid',$fields['id'])->get();
        $memberx = Member::where('teamid',$member[0]->teamid)->get();
        $actif = [];
        $k=-1;
        for ($i=1;$i<sizeof($memberx);$i++)
        {
            
                $user=User::where('id',$memberx[$i]->userid)->get();
                $k=$k+1;
                $actif[$k]=$user[0];
                    
        }
        return response($actif, 201);
  }   
        
     public function changetaskstatus(Request $request){
            $fields = $request->validate([
                'id' => 'required|string',
                "Status"=> 'required|string',
            ]);
            Jirabcp::where('Issue', $fields['id'])
            ->update(['Status' => $request->Status]);
        }
}