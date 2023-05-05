<?php
namespace Pixiekat\FhirGenomexPhpBridge;

interface GenomicsOpsApiInterface {

  /**
   * Getter for $subject.
   *
   * @access public
   * @return string
   */
  public function getSubject(): ?string;

  /**
   * Setter for $subject.
   *
   * @access public
   * @param $subject string The subject to reference
   * @return Pixiekat\FhirGenomexPhpBridge\GenomicsOpsAPi
   */
  public function setSubject(string $subject): self;
}
