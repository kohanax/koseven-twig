<?php

/**
 * Twig loader for Kohana's cascading filesystem
 */
class Twig_Loader_CFS implements Twig\Loader\LoaderInterface {

	/**
	 * Loader configuration
	 */
	protected $_config;

	/**
	 * Constructor
	 *
	 * @param  array  $config  Loader configuration
	 */
	public function __construct($config)
	{
		$this->_config = $config;
	}

	/**
	 * Find a template file in the cascading filesystem
	 *
	 * @param   string  $name  Base name of template file
	 * @return  string  Path to template file
	 */
	public function find_template($name): string
	{
		if (($path = Kohana::find_file($this->_config['path'], $name, $this->_config['extension'])) === FALSE)
		{
			throw new \Twig\Error\LoaderError('The requested twig "'.$name.'" could not be found!');
		}

		return $path;
	}

	/**
	 * Get the contents of template
	 *
	 * @param   string  $name  Base name of template
	 * @return  string  Contents of template
	 */
	public function getSource($name): string
	{
		return file_get_contents($this->find_template($name));
	}

	/**
	 * Get the cache key of template
	 *
	 * @param   string  $name  Base name of template
	 * @return  string  Cache key of template
	 */
	public function getCacheKey($name): string
	{
		return $name;
	}

	/**
	 * Determine if compiled template is fresh
	 *
	 * @param   string  $name  Base name of template
	 * @param   int     $time  Timestamp to compare against
	 * @return  bool    TRUE if compiled template is older than timestamp
	 */
	public function isFresh($name, $time): bool
	{
        return filemtime($this->find_template($name)) <= $time;
	}

	/**
	 * Returns twig source context.
	 *
	 * @param string $name Base name of template
	 * @return \Twig\Source
	 * @throws \Twig\Error\LoaderError
	 */
	public function getSourceContext($name): \Twig\Source
	{
		$path = $this->find_template($name);

		return new \Twig\Source(file_get_contents($path), $name, $path);
	}

	/**
	 * Checks if file exists.
	 * 
	 * @param   string  $name  Base name of template
	 * @return  bool    TRUE if template exists
	 */
	public function exists($name): bool
	{
		return ! empty($this->find_template($name));
	}
} // End CFS
