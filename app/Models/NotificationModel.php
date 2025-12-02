<?php
namespace App\Models;
use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'type',
        'channel',
        'recipient',
        'subject',
        'message',
        'is_sent',
        'sent_at',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;

    /**
     * Type: email, whatsapp, sms, in_app
     * Channel: notification_email, notification_whatsapp, notification_sms
     */

    public function createNotification($user_id, $type, $channel, $recipient, $subject, $message)
    {
        return $this->insert([
            'user_id' => $user_id,
            'type' => $type,
            'channel' => $channel,
            'recipient' => $recipient,
            'subject' => $subject,
            'message' => $message,
            'is_sent' => false
        ]);
    }

    public function getPendingNotifications()
    {
        return $this->where('is_sent', false)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function markAsSent($id)
    {
        return $this->update($id, [
            'is_sent' => true,
            'sent_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getUserNotifications($user_id, $limit = 10)
    {
        return $this->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
