<?php
namespace Terminus\Commands;

use Terminus\Models\Collections\Sites;

/**
 * Actions on multiple sites
 *
 * @command sites
 */
class OmniscientCommand extends TerminusCommand {
  /**
   * @var \Terminus\Models\Collections\Sites
   */
  public $sites;

  /**
   * Enable New Relic Pro for all your Pantheon sites simultaneously
   *
   * @param array $options
   * @return PantheonAliases
   */
  public function __construct(array $options = []) {
    $options['require_login'] = true;
    parent::__construct($options);
    $this->sites = new Sites();
  }

   /**
   * Connects SequelPro to the Site
   *
   * ## OPTIONS
   *
   * [--site=<site>]
   * : Site to Use
   *
   * [--env=<env>]
   * : Environment to clear
   *
   * ## EXAMPLES
   *  terminus site pancakes --site=test
   *
   * @subcommand omniscient
   */
  public function omniscient($args, $assoc_args) {
    // Always fetch a fresh list of sites.
    if (!isset($assoc_args['cached'])) {
      $this->sites->rebuildCache();
    }
    $sites = $this->sites->all();

    foreach ($sites as $site) {
      $site_name = $site->get('name');
      $new_relic_info = $site->newrelic();
      // If New Relic is disabled, enable it
      if (is_null($new_relic_info)) {
        if ((boolean) $site->get('frozen')) {
          $this->log()->info("Skipping $site_name because it is frozen.");
        } else {
          $workflow = $site->workflows->create('enable_new_relic_for_site', ['site' => $site->get('id'),]);
          $workflow->wait();
          $this->log()->info("Enabled New Relic Pro for $site_name.");
        }
      } else {
        $this->log()->info("Skipping $site_name because New Relic Pro is already enabled.");
      }
    }
  }
}
