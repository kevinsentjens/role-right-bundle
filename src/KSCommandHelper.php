<?php


namespace KS\RoleRightBundle;

/**
 * Class KSCommandHelper used for setting the necessary files
 * @author Kevin Sentjens <kevinsentjens.dev@gmail.com>
 */
class KSCommandHelper
{
    private $appDirectory;
    private $files = [];

    public function __construct(string $appDirectory)
    {
        $this->setAppDirectory($appDirectory);
    }

    private function setFile($file): void
    {
        $this->files[] = [
            'file' => $file,
            'type' => ucfirst(basename(dirname($file))),
            'newName' => str_replace('.tpl', '', basename($file))
        ];
    }

    public function generate(): bool
    {
        // Scan the skeleton directory for any template files and put them in an array
        foreach (glob(__DIR__.'/Resources/skeleton/*/*.tpl.php') as $file)
        {
            if (!empty($file))
            {
                $this->setFile($file);
            }
        }

        foreach ($this->files as $file)
        {
            if (!file_exists($file['file']))
            {
                // TODO: Throw error
                return false;
            }

            if (!file_put_contents($this->getAppDirectory().'/src/'.$file['type'].'/'.$file['newName'] ,file_get_contents($file['file'])))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function getAppDirectory(): string
    {
        return $this->appDirectory;
    }

    /**
     * @param string $appDirectory
     */
    public function setAppDirectory(string $appDirectory): void
    {
        $this->appDirectory = $appDirectory;
    }
}