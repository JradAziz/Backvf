<?php

namespace App\Http\Controllers;
use App\Models\Jirabcp;
use App\Models\Member;
use App\Models\Team;
use App\Models\Task;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class TransferdataController extends Controller
{
    //
    public function send()
    {
        $all=Jirabcp::all();
        $tasks=Task::all();
        for ($i=0;$i<sizeof($all);$i++)
        {
            $cond=Task::Where(['Issue' =>$all[$i]->Issue,])->get();
            if(!($cond)|| $all[$i]->Status!="Closed")
            {
                if ($all[$i]->Assignee==NULL)
                {
                Task::insert(
                    ['Issue' =>$all[$i]->Issue,
                     'Project' => $all[$i]->Project,
                     'Summary' => $all[$i]->Summary,
                     'Type' => $all[$i]->Type,
                     'ResolutionDate' => $all[$i]->ResolutionDate,
                     'TesterSup' => $all[$i]->TesterSup,
                     'Labels' => $all[$i]->Labels,
                     'Priority' => $all[$i]->Priority,
                     'Status' => $all[$i]->Status,
                     'Assignee' => $all[$i]->Assignee,
                     'Creator' => $all[$i]->Creator,
                     'Duedate' => $all[$i]->Duedate,
                     'ProblemCategory' => $all[$i]->ProblemCategory,
                     'Versions' => $all[$i]->Versions,
                     'TeamSwbk' => $all[$i]->TeamSwbk,
                     'Created' => $all[$i]->Created,
                     'Award' => $all[$i]->Award,
                     'SlipThroughCategory' => $all[$i]->SlipThroughCategory,
                     'TeamTesterSup' => $all[$i]->TeamTesterSup,
                     'SlipThroughAnalysis' => $all[$i]->SlipThroughAnalysis,
                     'SupplierCustomField' => $all[$i]->SupplierCustomField,
                     ] );

                }
            
                    if ($all[$i]->Assignee!=NULL)
                    {
                        $req=User::Where('name',$all[$i]->Assignee)->first();
                        $req2=Team::Where('Teamname',$all[$i]->TeamTesterSup)->first();
                        if($req)
                        {
                            Task::insert(
                                ['Issue' =>$all[$i]->Issue,
								 'Project' => $all[$i]->Project,
								 'Summary' => $all[$i]->Summary,
								 'Type' => $all[$i]->Type,
								 'ResolutionDate' => $all[$i]->ResolutionDate,
								 'TesterSup' => $all[$i]->TesterSup,
								 'Labels' => $all[$i]->Labels,
								 'Priority' => $all[$i]->Priority,
								 'Status' => $all[$i]->Status,
								 'Assignee' => $all[$i]->Assignee,
								 'Creator' => $all[$i]->Creator,
								 'Reporter'=>$all[$i]->Reporter,
								 'Components'=>$all[$i]->Components,
								 'Resolution'=>$all[$i]->Resolution,
								 'TeamSyst'=>$all[$i]->TeamSyst,
								 'Duedate' => $all[$i]->Duedate,
								 'ProblemCategory' => $all[$i]->ProblemCategory,
								 'Versions' => $all[$i]->Versions,
                                 'Created' => $all[$i]->Created,
								 'TeamSwbk' => $all[$i]->TeamSwbk,
								 'Award' => $all[$i]->Award,
								 'SlipThroughCategory' => $all[$i]->SlipThroughCategory,
								 'TeamTesterSup' => $all[$i]->TeamTesterSup,
								 'SlipThroughAnalysis' => $all[$i]->SlipThroughAnalysis,
								 'SupplierCustomField' => $all[$i]->SupplierCustomField,
                                 'Assigneeid'=>$req->id,
                                 ] );
            
                            
                        }
                        if ($req==NULL)
                        {
                            Task::insert(
                                ['Issue' =>$all[$i]->Issue,
										'Project' => $all[$i]->Project,
										'Summary' => $all[$i]->Summary,
									 'Type' => $all[$i]->Type,
									 'ResolutionDate' => $all[$i]->ResolutionDate,
									 'TesterSup' => $all[$i]->TesterSup,
									 'Labels' => $all[$i]->Labels,
									 'Priority' => $all[$i]->Priority,
									 'Status' => $all[$i]->Status,
									 'Assignee' => $all[$i]->Assignee,
									 'Creator' => $all[$i]->Creator,
                                     'Created' => $all[$i]->Created,
									 'Reporter'=>$all[$i]->Reporter,
									 'Components'=>$all[$i]->Components,
									 'Resolution'=>$all[$i]->Resolution,
									 'TeamSyst'=>$all[$i]->TeamSyst,
									 'Duedate' => $all[$i]->Duedate,
									 'ProblemCategory' => $all[$i]->ProblemCategory,
									 'Versions' => $all[$i]->Versions,
									 'TeamSwbk' => $all[$i]->TeamSwbk,
									 'Award' => $all[$i]->Award,
									 'SlipThroughCategory' => $all[$i]->SlipThroughCategory,
									 'TeamTesterSup' => $all[$i]->TeamTesterSup,
									 'SlipThroughAnalysis' => $all[$i]->SlipThroughAnalysis,
									 'SupplierCustomField' => $all[$i]->SupplierCustomField,
                                 ] );
                        }

                    }
                
                    


                
            

            }
        }
    }
    public function index()
    {  
         $actif = [];
         $l=-1;
        $all=Jirabcp::all();
        for ($i=0;$i<sizeof($all);$i++)
        {
            if($all[$i]->TeamTesterSup!="nan" && $all[$i]->Assignee!=NULL)
            {   
                $l++;
                $actif[$l] =$all[$i]->TeamTesterSup ."||". $all[$i]->Assignee;
                $teams=Team::Where(['Teamname' =>$all[$i]->TeamTesterSup,])->first();
                $users=User::Where(['name' =>$all[$i]->Assignee,])->first();
                if($users!=NULL)
                {   
                   
                    Member::insert(
                        [
                        'teamid' =>4,
                         'userid' =>$users->id
                         ]
    
                    );

                }


            }
        }
        return response($actif, 201);
    }
}
