<div class="static-container one-column">
    <h1>Contact form</h1>

    <form method="post" action="{{ route('contact-from.mail') }}">
        @csrf

        <div class="control-group">
            <label for="first_name" class="required">{{ __('shop::app.customer.signup-form.firstname') }}</label>
            <input type="text" class="control" name="first_name" value="{{ old('first_name') }}" required>
        </div>

        <div class="control-group">
            <label for="last_name">{{ __('shop::app.customer.signup-form.lastname') }}</label>
            <input type="text" class="control" name="last_name" value="{{ old('last_name') }}">
        </div>

        <div class="control-group">
            <label for="email" class="required">{{ __('shop::app.customer.signup-form.email') }}</label>
            <input type="email" class="control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="control-group">
            <label for="messsage" class="required">{{ __('Message') }}</label>
            <textarea type="messsage" class="control" name="messsage" value="{{ old('messsage') }}" required>Write message...</textarea>
        </div>

        <input class="btn btn-primary btn-sm" type="submit">
    </form>
</div>