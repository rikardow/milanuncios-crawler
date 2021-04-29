@extends('layouts.app')

@section('content')
<v-row>
    <v-col cols="12">
        <filter-form :categories="{{ $categories }}">

        </filter-form>
    </v-col>
</v-row>

<v-row>
    <v-col cols="8" offset="2">
        <ad-card :ad="{{ $ad }}" :expand="true">

        </ad-card>
    </v-col>
</v-row>

@endsection
