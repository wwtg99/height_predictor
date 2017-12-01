<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/12/1
 * Time: 13:18
 */

namespace App\Servers;


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
        return $this->predict($f);
    }

    /**
     * @param $genotypeFile
     * @param $gender
     * @param $source
     * @return string|bool
     */
    public function parseInputs($genotypeFile, $gender, $source = null)
    {
        if (!file_exists($genotypeFile)) {
            return false;
        }
        $output = $this->getPreprocessedGenotypePath();
        $cmd = [$this->parseInputScript, '--genotype', $genotypeFile, '--output', $output, '--gender', $gender];
        if ($this->snpType) {
            $cmd[] = "--snp-list=$this->snpType";
        }
        if ($source) {
            $cmd[] = "--source=$source";
        }
        $re = $this->runScript($cmd);
        return $output;
    }

    /**
     * @param $processedFile
     * @return string|bool
     */
    public function predict($processedFile)
    {
        if (!file_exists($processedFile)) {
            return false;
        }
        $cmd = [$this->predictScript, $processedFile, '--model-dir', $this->modelDir, '--quiet'];
        if ($this->models) {
            $cmd[] = '--model ' . implode(',', $this->models);
        }
        $re = $this->runScript($cmd);
        return $re;
    }

    /**
     * @return string
     */
    protected function getPreprocessedGenotypePath()
    {
        $id = str_random();
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
        $c = implode(' ', $cmd);
        logger()->debug("Run script: $c");
        return exec($c, $output);
    }
}