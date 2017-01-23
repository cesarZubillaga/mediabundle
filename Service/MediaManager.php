<?php
namespace MediaBundle\Service;

use MediaBundle\Entity\Media;
use Symfony\Component\HttpFoundation\File\File;

class MediaManager
{
    /**
     * @var string
     */
    private $targetDir;

    private $webDir;

    public function __construct($kernelRootDir, $mediaPath)
    {
        $this->webDir = sprintf('%s/../web/', $kernelRootDir);
        $this->targetDir = sprintf('%s/../web/%s', $kernelRootDir, $mediaPath);
    }

    public function upload(File $file)
    {
        $fileName = sha1(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    public function remove(Media $media, $fileName = null)
    {
        if(null == $fileName){
            $fileName = $media->getFile();
        }
        $fileName = sprintf('%s%s/%s', $this->webDir, $media->getPath(), $fileName);
        if(file_exists($fileName)){
            unlink($fileName);
        }
    }

}