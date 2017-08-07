<?php  
/**
 * @file
 * Contains \Drupal\data_exchange\Plugin\QueueWorker\data_exchangeQueueWorker.
 */

namespace Drupal\data_exchange\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Processes tasks for example module.
 *
 * @QueueWorker(
 *   id = "data_exchange",
 *   title = @Translation("Example: Queue worker"),
 *   cron = {"time" = 90}
 * )
 */
class data_exchangeQueueWorker extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($item) {
    
  }

}