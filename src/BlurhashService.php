<?php

namespace Drupal\blurhash;

use Drupal\file\Entity\File;
use GdImage;
use kornrunner\Blurhash;

/**
 * Blurhash service.
 */
class BlurhashService implements BlurhashServiceInterface {

  /**
   * @var \GdImage
   */
  private GdImage $image;

  /**
   * The constructor.
   */
  public function __construct(GdImage $image) {
    $this->image = $image;
  }

  /**
   * {@inheritdoc}
   */
  public function encode(): string {
    $width = imagesx($this->image);
    $height = imagesy($this->image);

    $pixels = [];
    for ($y = 0; $y < $height; ++$y) {
      $row = [];
      for ($x = 0; $x < $width; ++$x) {
        $index = imagecolorat($this->image, $x, $y);
        $colors = imagecolorsforindex($this->image, $index);

        $row[] = [$colors['red'], $colors['green'], $colors['blue']];
      }
      $pixels[] = $row;
    }

    return Blurhash::encode($pixels, 4, 3, FALSE);
  }

  /**
   * {@inheritdoc}
   */
  public function decode(string $blurhash, int $width, int $height): array {
    return Blurhash::decode($blurhash, $width, $height, 1.0, FALSE);
  }

  /**
   * {@inheritdoc}
   */
  public static function fromUri($uri): static {
    if ($string = file_get_contents($uri)) {
      $image = imagecreatefromstring($string);
    }
    return new static($image);
  }

  /**
   * {@inheritdoc}
   */
  public static function fromFile(File $file): static {
    // TODO: Implement fromFile() method.
    throw new Exception('Not implemented');
  }

}
