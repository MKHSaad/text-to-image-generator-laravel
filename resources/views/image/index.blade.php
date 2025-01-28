@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Generate a banner with Your Text</h1>
    <form id="imageForm" action="{{ route('generate.image') }}" method="POST">
        @csrf
        <!-- Role Selection -->
        <div class="mb-3">
            <label class="form-label d-inline-flex align-items-center me-3">Select Role</label>
            <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="role" value="bowler" class="form-check-input"> Bowler
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="role" value="batsman" class="form-check-input"> Batsman
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="role" value="wicket-keeper" class="form-check-input"> Wicket-Keeper
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="role" value="fielder" class="form-check-input"> Fielder
                    </label>
                </div>
            </div>
        </div>
        <!-- Ball Type Selection -->
        <div class="mb-3">
            <label class="form-label">Select Ball Type</label>
            <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="ballType" value="white ball" class="form-check-input"> White Ball
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="ballType" value="red ball" class="form-check-input"> Red Ball
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="ballType" value="pink ball" class="form-check-input"> Pink Ball
                    </label>
                </div>
            </div>
        </div>
        <!-- Extra Prompt -->
        <div class="mb-3">
            <textarea id="extraPrompt" name="extraPrompt" class="form-control" placeholder="Add extra details (optional)" rows="3"></textarea>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Generate Image</button>
        <button type="button" class="btn btn-secondary w-100 mt-2" id="clearSelection">Clear Selection</button>
    </form>

    <div id="loading" class="text-center text-muted mt-3 d-none">
        <div class="spinner-border text-primary" role="status"></div>
        <p>Generating image...</p>
    </div>

    <div id="error" class="text-danger mt-2 d-none"></div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#imageForm').submit(function() {

            const role = document.querySelector('input[name="role"]:checked')?.value;
            const ballType = document.querySelector('input[name="ballType"]:checked')?.value;
            const extraPrompt = $('#extraPrompt').val().trim();

            if (!role || !ballType) {
                $('#error').text('Please select role and ball type.').removeClass('d-none');
                return;
            }

            $('#loading').removeClass('d-none');
            $('#error').addClass('d-none');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loading").removeClass("d-none");
                    $("#error").addClass("d-none");
                },
                error: function(xhr) {
                    $("#error").removeClass("d-none").text(xhr.responseJSON.error || "Something went wrong");
                },
            });
        });
    });
</script>

<script>
    $('#clearSelection').click(function() {
        $('input[name="role"]').prop('checked', false);
        $('input[name="ballType"]').prop('checked', false);
        $('#extraPrompt').val('');
        $('#error').addClass('d-none');
    });
</script>
@endpush