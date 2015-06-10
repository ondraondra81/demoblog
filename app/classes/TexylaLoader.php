<?php
/**
 * Texyla loader
 *
 * @author Jan Marek
 */
class TexylaLoader extends WebLoader\Nette\JavaScriptLoader
{
	/** @var string */
	private $tempUri;

    /**
     * Construct
     *
     * @param \WebLoader\Compiler $filter
     * @param null                $tempUri
     *
     * @throws \WebLoader\InvalidArgumentException
     * @param parent $IContainer
     * @param name $string
     */
	public function __construct($filter, $tempUri, $tempDir) {
		
		$files = new \WebLoader\FileCollection(__DIR__ . "/../client/js/");
		$files->addFiles(array(
            "js/texyla-init.js"
		));

	    $compiler = \WebLoader\Compiler::createJsCompiler($files, $tempDir);

		// setup filter
		$compiler->addFilter($filter);

		// minifying JS


		parent::__construct($compiler, $tempUri);
	}

}