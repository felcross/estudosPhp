<?php
namespace Base;

interface FormElementInterface {

  public function setName($name);

  public function getName();

  public function setValue($name);

  public function getvalue();

  public function show($show);

}