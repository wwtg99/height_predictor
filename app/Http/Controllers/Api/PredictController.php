<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Servers\Predictor;
use Illuminate\Http\Request;

class PredictController extends Controller
{

    public function predict(Request $request)
    {
        $genotype = $request->file('genotype');
        if (!$genotype->isValid()) {
            return response()->json(['error'=>'invalid file']);
        }
        $gender = $request->input('gender');
        if (!$gender || !in_array($gender, ['male', 'female'])) {
            return response()->json(['error'=>'invalid gender']);
        }
        $source = $request->input('source');
        $predictor = new Predictor();
        $pre = $predictor->predictHeight($genotype->getRealPath(), $gender, $source);
        if (!$pre) {
            return response()->json(['error'=>'predict failed']);
        }
        return response()->json(['height'=>$pre]);
    }

    public function modelsList()
    {
        $predictor = new Predictor();
        return response()->json(['models'=>$predictor->getModelList()]);
    }

    public function sourceList()
    {
        $source = [
            'none' => 'Custom',
            '23andme' => '23 and me',
            '23andme-exome-vcf' => '23 and me exome vcf',
            'ftdna-illumina' => 'ftdna-illumina',
            'ftdna' => 'ftdna',
            'decodeme' => 'decode me',
            'vcf' => 'vcf',
        ];
        return response()->json($source);
    }
}
