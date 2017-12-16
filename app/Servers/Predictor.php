<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/12/1
 * Time: 13:18
 */

namespace App\Servers;


use Illuminate\Http\UploadedFile;

class Predictor
{

    /**
     * Store tmp files
     *
     * @var string
     */
    protected $storeDir;

    /**
     * Directory for scripts
     *
     * @var string
     */
    protected $scriptsDir;

    /**
     * @var string
     */
    protected $parseInputScript;

    /**
     * @var string
     */
    protected $predictScript;

    /**
     * @var string
     */
    protected $modelDir;

    /**
     * Python path
     *
     * @var string
     */
    protected $python;

    /**
     * @var array
     */
    protected $models;

    /**
     * @var string
     */
    protected $snpType;

    /**
     * @var string
     */
    protected $error = '';

    /**
     * @var int
     */
    protected $minSnp = 40;

    /**
     * Predictor constructor.
     *
     * @param array|string $models
     * @param $snpType
     */
    public function __construct($models = null, $snpType = null)
    {
        if ($models && is_array($models)) {
            $this->models = $models;
        } elseif ($models) {
            $this->models = explode(',', $models);
        }
        $this->snpType = $snpType;
        $this->storeDir = storage_path('app' . DIRECTORY_SEPARATOR . 'genotypes');
        $this->scriptsDir = base_path('scripts');
        $this->parseInputScript = $this->scriptsDir . DIRECTORY_SEPARATOR . 'parse_inputs.py';
        $this->predictScript = $this->scriptsDir . DIRECTORY_SEPARATOR . 'predict.py';
        $this->modelDir = $this->scriptsDir . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . '119';
        $this->python = config('services.python_bin');
    }

    /**
     * @return array
     */
    public function getModelList()
    {
        $out = [];
        $this->runScript([$this->predictScript, 'a', '-l'], $out);
        return $out;
    }

    /**
     * @param $genotypeFile
     * @param $gender
     * @param $source
     * @return string|bool
     */
    public function predictHeight($genotypeFile, $gender, $source = null)
    {
        $f = $this->parseInputs($genotypeFile, $gender, $source);
        if (!$f) {
            return $f;
        }
        if ($this->error) {
            return false;
        }
        return $this->predict($f);
    }

    /**
     * @param UploadedFile $genotypeFile
     * @param $gender
     * @param $source
     * @return string|bool
     */
    public function parseInputs($genotypeFile, $gender, $source = null)
    {
        if (!file_exists($genotypeFile->getRealPath())) {
            $this->error = 'genotype file not exists';
            return false;
        }
        $genotypeFile = $genotypeFile->store('genotypes');
        $id = pathinfo($genotypeFile, PATHINFO_FILENAME);
        $output = $this->getPreprocessedGenotypePath($id);
        $cmd = [$this->parseInputScript, '--genotype', storage_path('app' . DIRECTORY_SEPARATOR . $genotypeFile), '--output', $output, '--gender', $gender, '--min-snp', $this->minSnp];
        if ($this->snpType) {
            $cmd[] = "--snp-list=$this->snpType";
        }
        if ($source && $source != 'null') {
            $cmd[] = "--source=$source";
        }
        $re = $this->runScript($cmd);
        if (starts_with($re, 'Exception')) {
            $this->error = 'snp not enough';
            logger()->error($this->error);
        }
        return $output;
    }

    /**
     * @param $processedFile
     * @return string|bool
     */
    public function predict($processedFile)
    {
        if (!file_exists($processedFile)) {
            $this->error = 'preprocess file not exists';
            return false;
        }
        $cmd = [$this->predictScript, $processedFile, '--model-dir', $this->modelDir, '--quiet'];
        if ($this->models) {
            $cmd[] = '--model ' . implode(',', $this->models);
        }
        $re = $this->runScript($cmd);
        if (starts_with($re, 'Exception')) {
            $this->error = $re;
            logger()->error($this->error);
        }
        return $re;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param $id
     * @return string
     */
    protected function getPreprocessedGenotypePath($id = '')
    {
        if (!$id) {
            $id = str_random();
        }
        return $this->storeDir . DIRECTORY_SEPARATOR . "$id.csv";
    }

    /**
     * @param array $cmd
     * @param array $output
     * @return string
     */
    protected function runScript($cmd, &$output = null)
    {
        $output = [];
        $cmd = array_prepend($cmd, $this->python);
        $c = implode(' ', $cmd) . " 2>&1";
        logger()->debug("Run script: $c");
        return exec($c, $output);
    }
}