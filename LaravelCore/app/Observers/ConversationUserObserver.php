<?php

namespace App\Observers;

use App\Models\ConversationUser;

class ConversationUserObserver
{
    /**
     * Handle the ConversationUser "created" event.
     *
     * @param  \App\Models\ConversationUser  $conversationUser
     * @return void
     */
    public function created(ConversationUser $conversationUser)
    {
        //
    }

    /**
     * Handle the ConversationUser "updated" event.
     *
     * @param  \App\Models\ConversationUser  $conversationUser
     * @return void
     */
    public function updated(ConversationUser $conversationUser)
    {
        //
    }

    /**
     * Handle the ConversationUser "deleted" event.
     *
     * @param  \App\Models\ConversationUser  $conversationUser
     * @return void
     */
    public function deleted(ConversationUser $conversationUser)
    {
        //
    }

    /**
     * Handle the ConversationUser "restored" event.
     *
     * @param  \App\Models\ConversationUser  $conversationUser
     * @return void
     */
    public function restored(ConversationUser $conversationUser)
    {
        //
    }

    /**
     * Handle the ConversationUser "force deleted" event.
     *
     * @param  \App\Models\ConversationUser  $conversationUser
     * @return void
     */
    public function forceDeleted(ConversationUser $conversationUser)
    {
        //
    }
}
