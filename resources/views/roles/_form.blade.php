<div class="row g-3">
    <div class="col">
        <x-form.input
            name="name"
            label="Role Name"
            :value="old('name', isset($role) ? $role->name : '')"
            placeholder="Enter role name"
        />
    </div>

    <fieldset>
        <legend>
            Abilities
        </legend>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ability</th>
                    <th>Allow</th>
                    <th>Deny</th>
                    <th>Inherit</th>
                </tr>
            </thead>
            <tbody>
                @foreach (config('abilities') as $ability_code => $ability_name)
                    <tr>
                        <td>{{ $ability_name }}</td>
                        <td>
                            <input type="radio" name="abilities[{{ $ability_code }}]" value="allow"
                            @checked( isset($role_abilities[$ability_code]) && $role_abilities[$ability_code] === 'allow' )>
                        </td>
                        <td>
                            <input type="radio" name="abilities[{{ $ability_code }}]" value="deny"
                            @checked(isset($role_abilities[$ability_code]) && $role_abilities[$ability_code] === 'deny'  )>
                        </td>
                        <td>
                            <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit"
                            @checked( isset($role_abilities[$ability_code]) && $role_abilities[$ability_code] === 'inherit' )>
                        </td>
                    </tr>
                
                @endforeach
            </tbody>
        </table>
    </fieldset>
</div>