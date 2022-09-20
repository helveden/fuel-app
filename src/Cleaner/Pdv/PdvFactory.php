<?php

namespace App\Cleaner\Pdv;

use App\Entity\Pdv;
use App\Service\AbstractFactory;

class PdvFactory extends AbstractFactory {

    public function repo() {
        return $this->em()->getRepository(Pdv::class);
    }

    public function getAll() {
        return $this->repo()->findAll();
    }

    public function get($id) { 
        return $this->repo()->find($id);
    }

    public function getBy($params = []) {
        return $this->repo()->findBy($params);
    }

    public function getSearchBy($params = []) {
        return $this->repo()->searchBy($params);
    }

    public function saveCommandAll(array $pdvs = [], $io) {
        $io->progressStart();

        foreach ($io->progressIterate($pdvs) as $k => $pdv) {
            $this->save($pdv);
        }

        $io->progressFinish();
    }

    public function save($pdv) {
        $datas = [];

        $pdvDatas = json_decode($pdv, true);
        // savoir si le pdv existe
        $pdv = $this->getBy([
            'pdv_id' => $pdvDatas['@attributes']['id']
        ]);
        
        
        if($pdv === null || empty($pdv)):
            $pdv = new Pdv();
            $pdv->setPdvId($pdvDatas['@attributes']['id']);
            $pdv->setLatitude($pdvDatas['@attributes']['latitude']);
            $pdv->setLongitude($pdvDatas['@attributes']['longitude']);
            $pdv->setPostalcode($pdvDatas['@attributes']['cp']);
            $pdv->setAdresse($pdvDatas['adresse']);
            $pdv->setCity($pdvDatas['ville']); 
        endif;
        
        $jours = [];
        $automate2424 = "";
        if(!empty($pdvDatas['horaires'])):
            foreach($pdvDatas['horaires']['jour'] as $k => $j):
                $jours[] = $j['@attributes'];
            endforeach;
            $automate2424 = $pdvDatas['horaires']['@attributes']["automate-24-24"];
        endif;

        $prices = [];
        if(!empty($pdvDatas['prix'])):
            foreach($pdvDatas['prix'] as $k => $p):
                $prices[] = !empty($p['@attributes']) ? $p['@attributes'] : [];
            endforeach;
        endif;
        
        $services = [];
        if(!empty($pdvDatas['services'])):
            if(!empty($pdvDatas['services']['service'])):
                $services = $pdvDatas['services']['service'];
            endif;
        endif;

        $datas = [
            'id'             => $pdvDatas['@attributes']['id'],
            'latitude'       => $pdvDatas['@attributes']['latitude'],
            'longitude'      => $pdvDatas['@attributes']['longitude'],
            'cp'             => $pdvDatas['@attributes']['cp'],
            'pop'            => $pdvDatas['@attributes']['pop'],
            'adresse'        => $pdvDatas['adresse'],
            'ville'          => $pdvDatas['ville'],
            'services'       => $services,
            'horaires'       => $jours,
            'prix'           => $prices,
            "automate-24-24" => $automate2424,
        ];
        
        $pdv->setDatas($datas);

        $this->em()->persist($pdv);
        $this->em()->flush();

        return $datas;
    }
}