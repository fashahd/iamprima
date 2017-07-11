<?php
class ModelPMC extends CI_Model {
	
    function getPmcList($monotonyID,$role_type){
        $sql    = " SELECT a.monotonyID,a.monotonyDetailID,a.monotonyDetailDate,a.monotonyDetailSession, a.monotonyVolume, 
                    a.pmcActualCore as core, a.pmcActualWarmUp as warmup, a.pmcActualCoolDown as cooldown,
                    a.pmcVolumeCore as volcore, a.pmcVolumeWarmUp as volwarm, a.pmcVolumeCoolDown as volcool
                    FROM `master_monotony_detail` as a 
                    WHERE a.monotonyID = '$monotonyID' AND a.monotonyType = '$role_type' ORDER BY monotonyDetailDate ASC";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
    }
		
    function getPmcYear($year,$atlet){
        $sql = " SELECT a.monotonyAtletID, b.*
FROM master_monotony as a
LEFT JOIN master_monotony_detail as b on b.monotonyID = a.monotonyID
WHERE a.monotonyAtletID = '$atlet' AND YEAR(b.monotonyDetailDate) = '$year'";
                
        $query = $this->db->query($sql);
        if($query -> num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    
    function getPmcMonth($year,$month,$atlet){
        $sql = " SELECT a.monotonyAtletID, b.*
FROM master_monotony as a
LEFT JOIN master_monotony_detail as b on b.monotonyID = a.monotonyID
WHERE a.monotonyAtletID = '$atlet' AND YEAR(b.monotonyDetailDate) = '$year' AND MONTH(b.monotonyDetailDate) = '$month'";
                
        $query = $this->db->query($sql);
        if($query -> num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    function optionActualWarmUp($actualCore){
        $sql = "SELECT * FROM mdlmonotony_intensity order by intensity_id ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        if($result){
            $opt = "<input type='hidden' name='typePmc[]' value='warmUp'/>";
            $opt .= "<select class='browser-default js--animations' name='actualWarmUp[]'>";
                foreach ($result as $key) {
                    $actual = $key->intensity_id;
                    $ket = $key->intensity_name;
                    if($actualCore == $actual){
                        $slc = "selected";
                    }else{
                        $slc = "";
                    }
                    $opt .= "<option $slc value='$actual'>$actual - $ket</option>";
                }
            $opt .="</select>";
        }
        return $opt;
    }

    function optionActualCore($actualCore){
        $sql = "SELECT * FROM mdlmonotony_intensity order by intensity_id ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        if($result){
            $opt = "<input type='hidden' name='typePmc[]' value='core'/>";
            $opt .= "<select class='browser-default js--animations' name='actualCore[]'>";
                foreach ($result as $key) {
                    $actual = $key->intensity_id;
                    $ket = $key->intensity_name;
                    if($actualCore == $actual){
                        $slc = "selected";
                    }else{
                        $slc = "";
                    }
                    $opt .= "<option $slc value='$actual'>$actual - $ket</option>";
                }
            $opt .="</select>";
        }
        return $opt;
    }

    function optionActualCoolDown($actualCore){
        $sql = "SELECT * FROM mdlmonotony_intensity order by intensity_id ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        if($result){
            $opt = "<input type='hidden' name='typePmc[]' value='coolDown'/>";
            $opt .= "<select class='browser-default js--animations' name='actualCoolDown[]'>";
                foreach ($result as $key) {
                    $actual = $key->intensity_id;
                    $ket = $key->intensity_name;
                    if($actualCore == $actual){
                        $slc = "selected";
                    }else{
                        $slc = "";
                    }
                    $opt .= "<option $slc value='$actual'>$actual - $ket</option>";
                }
            $opt .="</select>";
        }
        return $opt;
    }

    function pmc_id(){
        $tr = "PMCA_";
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $sql = "SELECT left(a.pmc_id,5) as tr, mid(a.pmc_id,6,4) as fyear," 
                . " mid(a.pmc_id,10,2) as fmonth, mid(a.pmc_id,12,2) as fday,"
                . " right(a.pmc_id,4) as fno FROM master_pmc AS a"
                . " where left(a.pmc_id,5) = '$tr' and mid(a.pmc_id,6,4) = '$year'"
                . " and mid(a.pmc_id,10,2) = '$month' and mid(a.pmc_id,12,2)= '$day'"
                . " order by fyear desc, CAST(fno AS SIGNED) DESC LIMIT 1";
                
        $result = $this->db->query($sql);	
            
        if($result->num_rows($result) > 0) {
            $row = $result->row();
            $tr = $row->tr;
            $fyear = $row->fyear;
            $fmonth = $row->fmonth;
            $fday = $row->fday;
            $fno = $row->fno;
            $fno++;
        } else {
            $tr = $tr;
            $fyear = $year;
            $fmonth = $month;
            $fday = $day;
            $fno = 0;
            $fno++;
        }
        if (strlen($fno)==1){
            $strfno = "000".$fno;
        } else if (strlen($fno)==2){
            $strfno = "00".$fno;
        } else if (strlen($fno)==3){
            $strfno = "0".$fno;
        } else if (strlen($fno)==4){
            $strfno = $fno;
        }
        
        $id_goal = $tr.$fyear.$fmonth.$fday.$strfno;

        return $id_goal;
    }
}
?>