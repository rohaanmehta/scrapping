<?php

namespace App\Controllers;

class Game extends BaseController
{
    public function roll()
    {
        $arr = array(
            'dice1' => '1',
            'dice2' => '2',
            'total' => '3',
        );
        $this->db->table('rolls')->insert($arr);
        echo 'roll';exit;
        return view('index');
    }
    
    public function bet()
    {
        $userid = $this->session->get('user_id');
        $date = date('Y-m-d');
        $time = date('H');
        $exist = $this->db->table('bets')->where('user_id',$userid)->where('date',$date)->where('time',$time)->countAllResults();
        if($exist > 0 ){
            $json['result'] = 200;
            $json['msg'] = 'Already Placed a bet for this round';
            return $this->response->setJSON($json);
        }
        
        $arr = array(
            'total' => $_POST['total'],
            'amount' => $_POST['amount'],
            'time' => $time,
            'user_id' => $userid,
        );

        $json['result'] = 400;
        if($this->db->table('bets')->insert($arr)){
            $json['result'] = 200;
            $json['msg'] = 'bet placed succesfully';
        }
        return $this->response->setJSON($json);
    }
}
