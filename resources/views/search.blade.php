@extends('layouts.app')

@section('content')
<v-row>
    <v-col cols="12">
        <filter-form :categories="{{ $categories }}" :currentSearch="{{ json_encode($search) }}">

        </filter-form>
    </v-col>
</v-row>

<v-row>
    @forelse($results as $ad)
    <v-col cols="12" md="6" lg="4">
        <ad-card :ad="{{ $ad }}">

        </ad-card>
    </v-col>

    @empty
    <p>No hay resultados</p>
    @endforelse
</v-row>

@endsection
