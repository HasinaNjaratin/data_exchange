<?php
use Drupal\Core\Cron;
use Drupal\data_exchange\Plugin\QueueWorker;


/**
 * Implements hook_cron().
 */
/*function data_exchange_cron() {
  // Get queue.
  // $queue = \Drupal::queue('data_exchangeQueueWorker');

  $last_run = \Drupal::state()->get('data_exchange.last_run', 0);

  // If 60 minutes passed since last time.
  if ((REQUEST_TIME - $last_run) > 300) {
    // Do something.
    // $item = (object) ['uid' => $uid, 'subscriber_id' => $subscriber_id];

    $public = \Drupal::service('file_system')->realpath("public://");
    $path = $public.DIRECTORY_SEPARATOR."export.txt";
    unlink($path);
    // Update last run.
    \Drupal::state()->set('data_exchange.last_run', REQUEST_TIME);
  }

  // Create item to queue.
  // $queue->createItem($item);
}*/


