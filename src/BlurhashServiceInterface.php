<?php

namespace Drupal\blurhash;

use Drupal\file\Entity\File;

/**
 * Service description.
 */
interface BlurhashServiceInterface {

  /**
   * Encode a blurhash.
   *
   * @return string
   */
  public function encode(): string;

  /**
   * Decode a blurhash.
   *
   * @param string $blurhash
   * @param int $width
   * @param int $height
   *
   * @return array
   */
  public function decode(string $blurhash, int $width, int $height): array;

  /**
   * @param $uri
   *
   * @return static
   */
  public static function fromUri($uri): static;

  /**
   * @param \Drupal\file\Entity\File $file
   *
   * @return static
   */
  public static function fromFile(File $file): static;

}
