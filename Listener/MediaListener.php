<?php
/**
 *
 */
namespace MediaBundle\Listener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use MediaBundle\Entity\Media;
use MediaBundle\Service\MediaManager;
use Symfony\Component\HttpFoundation\File\File;

class MediaListener
{
    /**
     * @var MediaManager
     */
    private $mediaManager;

    private $memeBaseUrl;
    private $uploadMediaPath;

    public function __construct(MediaManager $fileUploader, $uploadMediaPath, $memeBaseUrl)
    {
        $this->mediaManager = $fileUploader;
        $this->memeBaseUrl = $memeBaseUrl;
        $this->uploadMediaPath = $uploadMediaPath;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Media && $entity->isMeme() && $entity->getFile() instanceof File
        ) {
            $this->uploadFile($entity);
        }
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $media = $event->getObject();
        $changeSet = $event->getEntityChangeSet();
        if ($media instanceof Media && $event->hasChangedField('file') && end($changeSet['file']) instanceof File) {
            $fileName = reset($changeSet['file']);
            $this->mediaManager->remove($media, $fileName);
            $this->uploadFile($media);
        }
    }

    public function preRemove(LifecycleEventArgs $event)
    {
        $media = $event->getEntity();
        if ($media instanceof Media && $media->isMeme()) {
            $this->mediaManager->remove($media);
        }
    }

    private function uploadFile(Media $entity)
    {
        /** @var File $file */
        $file = $entity->getFile();
        $entity->setMimeType($file->getMimeType());
        $entity->setPath($this->uploadMediaPath);
        $entity->setSize($file->getSize());
        $fileName = $this->mediaManager->upload($file);
        $entity->setFile($fileName);
        $url = $this->getUrl($fileName);
        $entity->setUrl($url);
        $entity->setUrlThumbnail($url);
    }

    public function getUrl($fileName)
    {
        return sprintf('%s%s', $this->memeBaseUrl, $fileName);
    }
}
