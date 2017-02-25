<?php

namespace TerminusPluginProject\Omniscient\Commands;

use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\Terminus\Site\SiteAwareInterface;
use Pantheon\Terminus\Site\SiteAwareTrait;

class OmniscientCommand extends TerminusCommand implements SiteAwareInterface
{
  use SiteAwareTrait;

  /**
   * Enables New Relic Pro on all sites/environments a user has access
   * to.
   *
   * @authorize
   *
   * @command sites:omniscient
   * @alias omniscient
   *
   * @usage terminus sites:omniscient
   */
  public function omniscient() {
    $this->sites()->fetch();

    $sites = $this->sites()->serialize();

    foreach ($sites as $site) {
      $site = $this->getSite($site['name']);
      $site_name = $site->getName();
      $new_relic_info = $site->getNewRelic();
      $new_relic_info->fetch();
      $new_relic_data = $new_relic_info->serialize();
      if (empty($new_relic_data)) {
        // New Relic is disabled.
        if ((boolean)$site->get('frozen')) {
          $this->log()->notice("Skipping $site_name because site is frozen.");
        }
        else {
          $new_relic_info->enable();
          $this->log()->notice("Enabled New Relic Pro for $site_name");
        }
      }
      else {
        $this->log()->notice("Skipping $site_name because New Relic Pro is already enabled.");
      }
    }
  }

}
