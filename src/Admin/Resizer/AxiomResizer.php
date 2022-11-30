<?php

/*
 * type: 'resize' (default)
 * scales image to desired 'width', 'height', longest 'maxside', shortest 'minside'
 *
 * type: 'crop'
 * scales and crops image to desired 'width' and 'height'
 *
 */
declare(strict_types=1);

namespace App\Admin\Resizer;

use Gaufrette\File;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Resizer\ResizerInterface;

final class AxiomResizer implements ResizerInterface
{
    private ImagineInterface $adapter;

    private int $mode;

    private MetadataBuilderInterface $metadata;

    public function __construct(ImagineInterface $adapter, int $mode, MetadataBuilderInterface $metadata)
    {
        $this->adapter = $adapter;
        $this->mode = $mode;
        $this->metadata = $metadata;
    }

    public function resize(MediaInterface $media, File $in, File $out, string $format, array $settings): void
    {
        $image = $this->adapter->load($in->getContent());

        $content = $image
            ->thumbnail($this->getBox($media, $settings), $this->mode)
            ->get($format, ['quality' => $settings['quality']]);

        $out->setContent($content, $this->metadata->get($media, $out->getName()));
    }

    public function getBox(MediaInterface $media, array $settings): Box
    {

        $size = $media->getBox();
        $imgWidth = $size->getWidth();
        $imgHeight = $size->getHeight();

        $imgRatio = $imgWidth / $imgHeight;

        $maxSide = !empty($settings['resizer_options']['maxside']) ? (int) $settings['resizer_options']['maxside'] : 0;
        $minSide = !empty($settings['resizer_options']['minside']) ? (int) $settings['resizer_options']['minside'] : 0;
        $width = !empty($settings['resizer_options']['width']) ? (int) $settings['resizer_options']['width'] : 0;
        $height = !empty($settings['resizer_options']['height']) ? (int) $settings['resizer_options']['height'] : 0;

        if (empty($settings['resizer_options']['type']) || $settings['resizer_options']['type'] !== 'crop') {
            $resizeType = 'resize';
        } else {
            $resizeType = 'crop';
        }

        if ($resizeType === 'resize') {

            // Resize

            if ($maxSide) {
                // Longest side provided
                if ($imgRatio >= 1) {
                    // Image is horizontal
                    $finalWidth = $maxSide;
                    $finalHeight = $maxSide / $imgRatio;
                } else {
                    // Image is vertical
                    $finalHeight = $maxSide;
                    $finalWidth = $maxSide * $imgRatio;
                }
            } else if ($minSide) {
                // Shortest side provided
                if ($imgRatio >= 1) {
                    // Image is horizontal
                    $finalHeight = $minSide;
                    $finalWidth = $minSide * $imgRatio;
                } else {
                    // Image is vertical
                    $finalWidth = $minSide;
                    $finalHeight = $minSide / $imgRatio;
                }
            } else if ($width) {
                $finalWidth = $width;
                $finalHeight = $width / $imgRatio;
            } else if ($height) {
                $finalHeight = $height;
                $finalWidth = $height * $imgRatio;
            } else {
                // No resize settings provided
                $finalWidth = $imgWidth;
                $finalHeight = $imgHeight;
            }

            // Check for upscale
            if ($finalWidth > $imgWidth) {
                // No upscale
                $finalWidth = $imgWidth;
                $finalHeight = $imgHeight;
            }
        } else if ($resizeType === 'crop') {

            // Crop

            $finalWidth = $width;
            $finalHeight = $height;
        }

        $finalWidth = (int) ceil($finalWidth);
        $finalHeight = (int) ceil($finalHeight);

        return new Box(
            $finalWidth,
            $finalHeight
        );
    }

}
