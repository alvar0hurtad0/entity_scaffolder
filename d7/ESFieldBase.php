<?php

require_once "ESEntityBase.php";

class ESFieldBase extends ESEntityBase {

  public function generateCode($info) {
    $module = 'fe_es';
    $filename = 'fe_es.features.field_base.inc';
    // Add File header.
    $block = ScaffolderBase::HEADER;
    $key = 0;
    $template = '/field_base/feature.header';
    $code = $this->scaffolder->render($template, $info);
    $this->scaffolder->setCode($module, $filename, $block, $key, $code);

    // Add Code block.
    $block = ScaffolderBase::CONTENT;
    $key = $info['machine_name'];
    $template = '/field_base/' . $info['type'] . '/feature.content';
    $code = $this->scaffolder->render($template, $info);
    $this->scaffolder->setCode($module, $filename, $block, $key, $code);

    // Add file footer.
    $block = ScaffolderBase::FOOTER;
    $key = 0;
    $template = '/field_base/feature.footer';
    $code = $this->scaffolder->render($template, $info);
    $this->scaffolder->setCode($module, $filename, $block, $key, $code);

    // Add entry to info file.
    $code = "\nfeatures[field_base][] = {$info['field_name']}";
    $module = 'fe_es';
    $filename = 'fe_es.info';
    $block = ScaffolderBase::CONTENT;
    $key = $code;
    $this->scaffolder->setCode($module, $filename, $block, $key, $code);
  }

  /**
   * Helper functions to create FPPS.
   */
  public function scaffold($config) {
    foreach ($config['fields'] as $field_key => $field_info) {
      $info = $this->getConfig($config, $field_key, $field_info);
      $this->generateCode($info);
    }
  }

  /**
   * Helper function to generate machine name for fields.
   */
  public function getFieldName($config, $field_key) {
    return $config['field_prefix'] . '_' . $field_key;
  }


  /**
   * Helper function to load config and defaults.
   */
  public function getConfig($config, $field_key, $field_info) {
    $info = $field_info;
    $info['field_name'] = $this->getFieldName($config, $field_key);
    $info['cardinality'] = !isset($info['cardinality']) ? 1 : $info['cardinality'];
    return $info;
  }

}
