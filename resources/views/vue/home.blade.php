<template id="dashboard-home">
   <div class="row row-grid">
       <div class="col-md-4">
           <h2>Schedule a Reminder</h2>
           {{-- New reminder form --}}
            <form class="flat-form overflow" @keydown.enter.prevent="" @submit.prevent="handleReminderSubmit">
                <label><span class="number">1</span>Phone Number</label>
                <span class="error-message" v-if="validationErrors.no_recipient">
                    <strong>@{{ validationErrors.no_recipient }}</strong>
                </span>
                <div class="suggestion-wrapper">
                    <input  type="text" placeholder="International format" id="fi_search"
                            v-model="query"
                            @focus="showSuggestions = true"
                            @blur="showSuggestions = false"
                            @keyup.down.prevent="highlightContact('down')"
                            @keyup.up.prevent="highlightContact('up')"
                            @keyup.enter.prevent="selectContact(highlightedContact)"
                            @input="validate"
                            autocomplete="off"
                            v-if="!isContactSelected"
                    >
                    {{-- Suggestion box to autocomplete contacts --}}
                    <div class="suggestionbox-wrapper" v-show="query.length > 1 && showSuggestions" v-if="!isContactSelected">
                        <div class="suggestionbox">
                            <p  v-for="(index, contact) in filteredContacts"
                                :class="{ 'active': contact.id == highlightedContact.id }"
                                @mouseenter="highlightContact(index)"
                                @mousedown="selectContact(contact)"
                            >
                                @{{contact.name}} (@{{contact.number}})
                            </p>
                        </div>
                    </div>
                    <p class="contact-view" v-if="isContactSelected">
                        @{{ selectedContact.name }} (@{{ selectedContact.number}})
                        <span class="cancel-contact" @click="resetRecipient" title="Reset">
                            <i class="fa fa-times-circle"></i>
                        </span>
                    </p>
                </div>

                <label><span class="number">2</span>Date &amp; time</label>
                <span class="error-message" v-if="validationErrors.send_datetime">
                    <strong>@{{ validationErrors.send_datetime }}</strong>
                </span>
                <datetimepicker :result.sync="newReminder.send_datetime"></datetimepicker>
                {{--
                <input type="text" placeholder="YYYY-MM-DD hh:mm" v-model="newReminder.send_datetime" @input="validate">
                --}}
                <label><span class="number">3</span>Message</label>
                <span class="error-message" v-if="validationErrors.message">
                    <strong>@{{ validationErrors.message }}</strong>
                </span>
                <textarea placeholder="Your message!" v-model="newReminder.message" @input="validate"></textarea>

                <label><span class="number">4</span>Repeat</label>
                <span class="error-message" v-if="validationErrors.repeat_id">
                    <strong>@{{ validationErrors.repeat_id }}</strong>
                </span>
                <select v-model="newReminder.repeat_id">
                    <option value="1">Never</option>
                    <option value="2">Daily</option>
                    <option value="3">Weekly</option>
                    <option value="4">Monthly</option>
                    <option value="5">Yearly</option>
                </select>

                <input type="submit" class="btn btn-submit" value="Submit" v-if="user.reminder_credits > 0">
                <input type="submit" class="btn btn-submit btn-disabled" value="No reminders!" disabled v-else>
            </form>
       </div>
        <div class="col-md-7 col-md-offset-1">
            <div class="remaining-credits">
                <img src="{{ url('img/chat.png')}}" alt="chat icon" />
                <p v-if="user.reminder_credits > 0">
                    You have <span class="remaining-amount">@{{ user.reminder_credits }}</span> remaining reminder<span v-if="user.reminder_credits > 1">s</span>.
                </p>
                <p v-else>
                    You're out of reminders. <a v-link="{ path: '/account' }">Buy more.</a>
                </p>
            </div>
            <table class="upcoming-table table">
                <thead>
                    <tr>
                        <th colspan="4">Upcoming Reminders</th>
                    </tr>
                    <tr>
                        <th>To</th>
                        <th>Date &amp; time</th>
                        <th>Message</th>
                        <th>Repeat</th>
                    </tr>
                </thead>
                <tbody v-if="remindersState.upcomingReminders.length != 0">
                    <tr v-for="reminder in remindersState.upcomingReminders | orderBy 'send_datetime'" is="reminder-row" :repeats="repeats" :reminder.sync="reminder"></tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" v-if="isLoading.getUpcomingReminders"><i class="fa fa-spinner fa-pulse"></i> Loading...</td>
                        <td colspan="4" v-else>No reminders yet!</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
