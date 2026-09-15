@if ($errors->any())
    <div class="alert" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-grid">
    <div class="field">
        <label class="field__label" for="first_name">Prénom</label>
        <input class="input" id="first_name" name="first_name" type="text" value="{{ old('first_name', $participant->first_name ?? '') }}" required maxlength="100" autofocus>
    </div>

    <div class="field">
        <label class="field__label" for="last_name">Nom</label>
        <input class="input" id="last_name" name="last_name" type="text" value="{{ old('last_name', $participant->last_name ?? '') }}" required maxlength="100">
    </div>
</div>

<div class="field">
    <label class="field__label" for="class_name">Classe</label>
    <input class="input" id="class_name" name="class_name" type="text" value="{{ old('class_name', $participant->class_name ?? '') }}" required maxlength="100" placeholder="Ex. B3 Informatique">
</div>

<div class="field">
    <label class="field__label" for="email">Adresse e-mail</label>
    <input class="input" id="email" name="email" type="email" value="{{ old('email', $participant->email ?? '') }}" required maxlength="255">
</div>

<button class="btn btn--primary" type="submit">{{ $submitLabel }}</button>
