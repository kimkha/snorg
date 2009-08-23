<?php
/**
* iZAP izap_videos
*
* @package youtube, vimeo, veoh and onserver uploading
* @license GNU Public License version 3
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.5-2.0
*/

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$queueStatus = (izapIsQueueRunning_izap_videos()) ? elgg_echo('izap_videos:running') : elgg_echo('izap_videos:notRunning');
$queuedVideos = get_entities('object', 'izapVideoQueue', 0, 0, 0, 0, true);
?>
<div class="usersettings_statistics">
  <h3><?php echo elgg_echo('izap_videos:queueStatus');?></h3>
    <table>
      <tbody>
        <tr class="odd">
          <td class="column_one"><?php echo elgg_echo('izap_videos:queueStatus')?></td>
          <td>
          <?php echo $queueStatus;?> &nbsp;&nbsp;
            <a href="?option=reset">
              <?php echo elgg_echo('izap_videos:resetNow')?>
            </a>
          </td>
        </tr>

        <tr class="odd">
          <td class="column_one"><?php echo elgg_echo('izap_videos:queuedFilesTotal')?></td>
          <td><?php echo $queuedVideos;?> &nbsp;&nbsp;
            <?php
              echo elgg_view('output/confirmlink', array(
                            'text' => elgg_echo('izap_videos:deleteNow'),
                            'href' => '?option=delete',
                            'confirm' => elgg_echo('izap_video:deleteQueue'),
                ));
            ?>
          </td>
        </tr>

      </tbody>
    </table>
</div>
