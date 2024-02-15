@extends('artistweb.layouts.main')
@section('body')
    <section class="main_section custom_container">
        <div class="navgat_otherpage">
            <h1 class="task_titlt"><a href="{{ url()->previous() }}"><span><img
                            src="{{ asset('/assets/fan/images/arrow-left.svg') }}" alt="arrow"></span></a>
                {{ ucfirst(trans($sc_event['event_title'])) }}</h1>
            <div class="button_gorup">
                {{-- <button onclick="endLive('{{$sc_event['event_id']}}')">End Live</button>  --}}
                {{-- <button onclick="myFunction()">Click me</button> --}}
                <span id="audioToggle" style="display: inline-block;margin-right:12px;font-size:27px;">
                    <span style="padding: 0px 8px;font-size: 18px;">Un mute the audio </span> <img
                        src="{{ asset('assets/web/images/mute.png') }}" alt="" style="height: 35px;">
                </span>
                <audio id="myAudio" src="{{ asset('assets/graph/audio/Crowd_1_100.mp3') }}" preload="auto" muted></audio>

                <a class="endlive"> <button>End Live</button></a>
                {{-- <a href="{{url('web/endlive/'.Crypt::encryptString($sc_event['event_id']))}}" class="endlive"> <button>End Live</button></a>  --}}
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-7 col-md-12 d-grid">
                <div class="event_bg">
                    <div class="imgsection">
                        <iframe src="{{ $sc_event['link_to_event_stream'] }}" frameborder="0" style="width:100%;height:100%"
                            allowfullscreen></iframe>
                    </div>
                    <div class="card_live">
                        <div class="live_fans">
                            <div class="live_fans_left">
                                <p class="font-18">Total Fans Booked</p>
                                <h2><span id="bookedcount"></span></h2>
                            </div>
                            <div class="live_fans_right">
                                <img src="{{ asset('/assets/web/images/fans_live.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="live_fans">
                            <div class="live_fans_left">
                                <p class="font-18">Total Fans Online</p>
                                <h2><a href="{{ url('web/userscount/' . base64_encode($sc_event['event_id'])) }}"><span
                                            id="livecount"></span></a></h2>
                            </div>
                            <div class="live_fans_right">
                                <img src="{{ asset('/assets/web/images/world_icon.svg') }}" alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="event_formsection h-100">
                    <div class="slider_header h-100">

                        <div class="main_live">
                            {{-- <div id="actt1">0</div> --}}
                            <div class="range-slider">
                                <!-- Button that triggers the audio play -->


                                <input type="hidden" name="event_id" id="event_id" value="{{ $sc_event['event_id'] }}">
                                <input type="hidden" name="user_id" id="user_id"
                                    value="{{ isset(auth()->user()->id) ? auth()->user()->id : '' }}">
                                <input type="range" orient="vertical" min="0" max="100" />
                                @foreach ($audio as $value)
                                    <audio id="{{ $value->audio_name . '_' . $value->block }}" src="{{ asset('assets/graph/audio/' . $value->audio_file) }}"></audio>
                                @endforeach
                                <div id="aact1"></div>
                                <div class="range-slider__thumb"></div>
                            </div>
                            <div class="emog_section"><img src="{{ asset('/assets/web/images/clap-svg.svg') }}"
                                    alt=""></div>
                        </div>

                        <div class="main_live">
                            {{-- <div id="actt2">0</div> --}}
                            <div class="range-slider">
                                <input type="range" orient="vertical" min="0" max="100" />
                                <div id="aact2"></div>
                                <div class="range-slider__thumb"></div>
                            </div>
                            <div class="emog_section"><img src="{{ asset('/assets/web/images/boo-svg.svg') }}"
                                    alt=""></div>
                        </div>

                        <div class="main_live">
                            {{-- <div id="actt3">0</div> --}}
                            <div class="range-slider">
                                <input type="range" orient="vertical" min="0" max="100" />
                                <div id="aact3"></div>
                                <div class="range-slider__thumb"></div>
                            </div>
                            <div class="emog_section"><img src="{{ asset('/assets/web/images/party-svg.svg') }}"
                                    alt=""></div>
                        </div>

                        <div class="main_live">
                            {{-- <div id="actt4">0</div> --}}
                            <div class="range-slider">
                                <input type="range" orient="vertical" min="0" max="100" value="0" />
                                <div id="aact4"></div>
                                <div class="range-slider__thumb"></div>
                            </div>
                            <div class="emog_section"><img src="{{ asset('/assets/web/images/music-svg.svg') }}"
                                    alt=""></div>
                        </div>
                        <div class="main_live">
                            {{-- <div id="actt5">0</div> --}}
                            <div class="range-slider">
                                <input type="range" orient="vertical" min="0" max="100" />
                                <div id="aact5"></div>
                                <div class="range-slider__thumb"></div>
                            </div>
                            <div class="emog_section"><img src="{{ asset('/assets/web/images/surprised-svg .svg') }}"
                                    alt=""></div>
                        </div>

                        <div class="main_live">
                            {{-- <div id="actt6">0</div> --}}
                            <div class="range-slider">
                                <input type="range" orient="vertical" min="0" max="100" value="0" />
                                <div id="aact6"></div>
                                <div class="range-slider__thumb"></div>
                            </div>
                            <div class="emog_section"><img src="{{ asset('/assets/web/images/smile-svg.svg') }}"
                                    alt=""></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>


    </section>
@endsection

@section('golive')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".endlive", function(e) {
                // var event_id = 1;
                var event_id = $("input[name=event_id]").val();
                e.preventDefault();
                Swal.fire({
                    title: 'Do you want to end the event?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        endLive(event_id);
                    }
                })

            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const audio = document.getElementById('myAudio');
            const audioToggle = document.getElementById('audioToggle');

            // Check if the audio was playing before
            const isAudioPlaying = localStorage.getItem('audioPlaying') === 'true';

            if (isAudioPlaying) {
                audio.play()
                    .then(() => {
                        console.log('Audio started playing');
                        audioToggle.style.display = 'none'; // Hide the button
                    })
                    .catch(error => {
                        console.error('Error playing audio:', error);
                    });
            }

            audioToggle.addEventListener('click', function() {
                if (audio.paused) {
                    audio.play()
                        .then(() => {
                            console.log('Audio started playing');
                            audioToggle.style.display = 'none'; // Hide the button
                            localStorage.setItem('audioPlaying', 'true'); // Store state
                        })
                        .catch(error => {
                            console.error('Error playing audio:', error);
                        });
                }
            });
        });
    </script>
    <script>
        var audios_files;
        var ajax_call = function() {
            var url = "/web/audiofiles";

            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    audios_files = data;
                },
            });
        };
        ajax_call();
        // $(document).ready(function(){

        // socket script
        var socket = io.connect("https://live-stream.f2s.live");
        //  var socket = io.connect("https://fan2stage-live.colanapps.in");



        signIn();

        function endLive(eventId) {
            socket.emit('end-event', {
                event: eventId
            });

        }




        function signIn() {
            var event_id = $('#event_id').val();
            var userid = $('#user_id').val();
            // var event_id = 233;
            // var userid = 43;

            socket.emit('join-event', {
                event: event_id,
                user_id: userid
            });
        }

        socket.on('joining-confirmation', (msg) => {
            console.log('My Socket Id: ', msg)
        });

        // event ending message
        socket.on('ended-the-event', (msg) => {
            if (msg['success'] == true) {
                Swal.fire({
                    title: 'Event has been ended!',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ url('/web/artisthome') }}";
                    }
                })
            }

        });
        // event ending message

        socket.on('live_fan_count', (msg) => {
            const livecount = msg['livecount'];
            $('#livecount').html(livecount);

            const audioElements = {
                1: Crowd1_1,
                2: Crowd2_2,
                3: Crowd3_3,
                4: Crowd4_4
            };

            let currentAudio = audioElements[livecount];

            if (!currentAudio) {
                // No audio should play if livecount doesn't match any defined condition
                Object.values(audioElements).forEach(audio => audio.pause());
                $('#bookedcount').html(msg['bookedcount']);
                $.clapsss(livecount);
                console.log('live_fan_count response:', msg);
                return;
            }

            $('#bookedcount').html(msg['bookedcount']);
            $.clapsss(livecount);
            console.log('live_fan_count response:', msg);

            currentAudio.loop = true; // Enable loop for current audio
            currentAudio.play();

            // Pause all other audio elements except the current one
            Object.values(audioElements).forEach(audio => {
                if (audio !== currentAudio) {
                    audio.pause();
                }
            });
        });



        socket.on('artist_action_graph_count', (msg) => {
            $.clapsss = function(count) {
                if (msg['act1'] > 0) {
                    let act1 = Math.min(msg['act1'], 10);
                    let GraphCount1 = (((act1 / 10) * 1.2) * (msg['c11'] / count)) * 100;
                    let GraphCount = Math.min(GraphCount1, 100);

                    document.getElementById("aact1").style.cssText = 'height:' + GraphCount + '%';

                    const stopAllClaps = Array.from(document.querySelectorAll('[id^="Clap"]'));
                    stopAllClaps.forEach(clap => $.stopAudio(clap));
                    const data = audios_files.data;
                    const datas = data.filter(item => item.audio_name.startsWith("Clap"));

                    const clapRanges = [];
                    // First block
                    if (datas.find(item => item.block === '1')) {
                        const firstBlockActRanges = datas
                            .filter(item => item.block === "1")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_1`]);

                        clapRanges.push({
                            actRanges: firstBlockActRanges,
                            countRange: [1, 2]
                        });
                    }

                    // Second block
                    if (datas.find(item => item.block === '2')) {
                        const secondBlockActRanges = datas
                            .filter(item => item.block === "2")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_2`]);

                        clapRanges.push({
                            actRanges: secondBlockActRanges,
                            countRange: [3, 6]
                        });
                    }
                    // third block
                    if (datas.find(item => item.block === '3')) {
                        const thirdBlockActRanges = datas
                            .filter(item => item.block === "3")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_3`]);

                        clapRanges.push({
                            actRanges: thirdBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fourth block
                    if (datas.find(item => item.block === '4')) {
                        const fourthBlockActRanges = datas
                            .filter(item => item.block === "4")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_4`]);

                        clapRanges.push({
                            actRanges: fourthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fifth block
                    if (datas.find(item => item.block === '5')) {
                        const fifthBlockActRanges = datas
                            .filter(item => item.block === "5")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_5`]);

                        clapRanges.push({
                            actRanges: fifthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }

                    for (const range of clapRanges) {
                        const [startCount, endCount] = range.countRange;
                        const [startAct, endAct, clap] = range.actRanges.find(([start, end]) => msg['c11'] >=
                            startCount && msg['c11'] <= endCount && act1 >= start && act1 <= end) || [];

                        const audioElement = document.getElementById(clap);


                        if (audioElement) {
                            audioElement.play();
                            break;
                        }

                    }
                } else {
                    document.getElementById("aact1").style.cssText = `height:0%`;
                }
                if (msg['act2'] > 0) {
                    let act2 = Math.min(msg['act2'], 10);
                    let GraphCount1 = (((act2 / 10) * 1.2) * (msg['c12'] / count)) * 100;
                    let GraphCount = Math.min(GraphCount1, 100);

                    document.getElementById("aact2").style.cssText = 'height:' + GraphCount + '%';

                    const stopAllBoos = Array.from(document.querySelectorAll('[id^="Boo"]'));
                    stopAllBoos.forEach(boo => $.stopAudio(boo));
                    const data = audios_files.data;
                    const datas = data.filter(item => item.audio_name.startsWith("Boo"));

                    const booRanges = [];
                    // First block
                    if (datas.find(item => item.block === '1')) {
                        const firstBlockActRanges = datas
                            .filter(item => item.block === "1")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_1`]);

                        booRanges.push({
                            actRanges: firstBlockActRanges,
                            countRange: [1, 2]
                        });
                    }

                    // Second block
                    if (datas.find(item => item.block === '2')) {
                        const secondBlockActRanges = datas
                            .filter(item => item.block === "2")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_2`]);

                        booRanges.push({
                            actRanges: secondBlockActRanges,
                            countRange: [3, 6]
                        });
                    }
                    // third block
                    if (datas.find(item => item.block === '3')) {
                        const thirdBlockActRanges = datas
                            .filter(item => item.block === "3")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_3`]);

                        booRanges.push({
                            actRanges: thirdBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fourth block
                    if (datas.find(item => item.block === '4')) {
                        const fourthBlockActRanges = datas
                            .filter(item => item.block === "4")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_4`]);

                        booRanges.push({
                            actRanges: fourthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fifth block
                    if (datas.find(item => item.block === '5')) {
                        const fifthBlockActRanges = datas
                            .filter(item => item.block === "5")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_5`]);

                        booRanges.push({
                            actRanges: fifthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }

                    for (const range of booRanges) {
                        const [startCount, endCount] = range.countRange;
                        const [startAct, endAct, boo] = range.actRanges.find(([start, end]) => msg['c12'] >=
                            startCount && msg['c12'] <= endCount && act2 >= start && act2 <= end) || [];

                        const audioElement = document.getElementById(boo);


                        if (audioElement) {
                            audioElement.play();
                            break;
                        }

                    }
                } else {
                    document.getElementById("aact2").style.cssText = `height:0%`;
                }
                if (msg['act3'] > 0) {
                    let act3 = Math.min(msg['act3'], 10);
                    let GraphCount1 = (((act3 / 10) * 1.2) * (msg['c13'] / count)) * 100;
                    let GraphCount = Math.min(GraphCount1, 100);

                    document.getElementById("aact3").style.cssText = 'height:' + GraphCount + '%';

                    const stopAllAwws = Array.from(document.querySelectorAll('[id^="Aww"]'));
                    stopAllAwws.forEach(aww => $.stopAudio(aww));
                    const data = audios_files.data;
                    const datas = data.filter(item => item.audio_name.startsWith("Aww"));

                    const awwRanges = [];
                    // First block
                    if (datas.find(item => item.block === '1')) {
                        const firstBlockActRanges = datas
                            .filter(item => item.block === "1")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_1`]);

                        awwRanges.push({
                            actRanges: firstBlockActRanges,
                            countRange: [1, 2]
                        });
                    }

                    // Second block
                    if (datas.find(item => item.block === '2')) {
                        const secondBlockActRanges = datas
                            .filter(item => item.block === "2")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_2`]);

                        awwRanges.push({
                            actRanges: secondBlockActRanges,
                            countRange: [3, 6]
                        });
                    }
                    // third block
                    if (datas.find(item => item.block === '3')) {
                        const thirdBlockActRanges = datas
                            .filter(item => item.block === "3")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_3`]);

                        awwRanges.push({
                            actRanges: thirdBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fourth block
                    if (datas.find(item => item.block === '4')) {
                        const fourthBlockActRanges = datas
                            .filter(item => item.block === "4")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_4`]);

                        awwRanges.push({
                            actRanges: fourthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fifth block
                    if (datas.find(item => item.block === '5')) {
                        const fifthBlockActRanges = datas
                            .filter(item => item.block === "5")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_5`]);

                        awwRanges.push({
                            actRanges: fifthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }

                    for (const range of awwRanges) {
                        const [startCount, endCount] = range.countRange;
                        const [startAct, endAct, aww] = range.actRanges.find(([start, end]) => msg['c13'] >=
                            startCount && msg['c13'] <= endCount && act3 >= start && act3 <= end) || [];

                        const audioElement = document.getElementById(aww);


                        if (audioElement) {
                            audioElement.play();
                            break;
                        }

                    }
                } else {
                    document.getElementById("aact3").style.cssText = `height:0%`;
                }
                if (msg['act4'] > 0) {
                    let act4 = Math.min(msg['act4'], 10);
                    let GraphCount1 = (((act4 / 10) * 1.2) * (msg['c14'] / count)) * 100;
                    let GraphCount = Math.min(GraphCount1, 100);

                    document.getElementById("aact4").style.cssText = 'height:' + GraphCount + '%';

                    const stopAllWhistles = Array.from(document.querySelectorAll('[id^="Whistle"]'));
                    stopAllWhistles.forEach(whistle => $.stopAudio(whistle));
                    const data = audios_files.data;
                    const datas = data.filter(item => item.audio_name.startsWith("Whistle"));

                    const whistleRanges = [];
                    // First block
                    if (datas.find(item => item.block === '1')) {
                        const firstBlockActRanges = datas
                            .filter(item => item.block === "1")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_1`]);

                        whistleRanges.push({
                            actRanges: firstBlockActRanges,
                            countRange: [1, 2]
                        });
                    }

                    // Second block
                    if (datas.find(item => item.block === '2')) {
                        const secondBlockActRanges = datas
                            .filter(item => item.block === "2")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_2`]);

                        whistleRanges.push({
                            actRanges: secondBlockActRanges,
                            countRange: [3, 6]
                        });
                    }
                    // third block
                    if (datas.find(item => item.block === '3')) {
                        const thirdBlockActRanges = datas
                            .filter(item => item.block === "3")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_3`]);

                        whistleRanges.push({
                            actRanges: thirdBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fourth block
                    if (datas.find(item => item.block === '4')) {
                        const fourthBlockActRanges = datas
                            .filter(item => item.block === "4")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_4`]);

                        whistleRanges.push({
                            actRanges: fourthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fifth block
                    if (datas.find(item => item.block === '5')) {
                        const fifthBlockActRanges = datas
                            .filter(item => item.block === "5")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_5`]);

                        whistleRanges.push({
                            actRanges: fifthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }

                    for (const range of whistleRanges) {
                        const [startCount, endCount] = range.countRange;
                        const [startAct, endAct, whistle] = range.actRanges.find(([start, end]) => msg['c14'] >=
                            startCount && msg['c14'] <= endCount && act4 >= start && act4 <= end) || [];

                        const audioElement = document.getElementById(whistle);


                        if (audioElement) {
                            audioElement.play();
                            break;
                        }

                    }
                } else {
                    document.getElementById("aact4").style.cssText = `height:0%`;
                }
                if (msg['act5'] > 0) {
                    let act5 = Math.min(msg['act5'], 10);
                    let GraphCount1 = (((act5 / 10) * 1.2) * (msg['c15'] / count)) * 100;
                    let GraphCount = Math.min(GraphCount1, 100);

                    document.getElementById("aact5").style.cssText = 'height:' + GraphCount + '%';

                    const stopAllCheers = Array.from(document.querySelectorAll('[id^="Cheer"]'));
                    stopAllCheers.forEach(cheer => $.stopAudio(cheer));
                    const data = audios_files.data;
                    const datas = data.filter(item => item.audio_name.startsWith("Cheer"));

                    const cheerRanges = [];
                    // First block
                    if (datas.find(item => item.block === '1')) {
                        const firstBlockActRanges = datas
                            .filter(item => item.block === "1")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_1`]);

                        cheerRanges.push({
                            actRanges: firstBlockActRanges,
                            countRange: [1, 2]
                        });
                    }

                    // Second block
                    if (datas.find(item => item.block === '2')) {
                        const secondBlockActRanges = datas
                            .filter(item => item.block === "2")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_2`]);

                        cheerRanges.push({
                            actRanges: secondBlockActRanges,
                            countRange: [3, 6]
                        });
                    }
                    // third block
                    if (datas.find(item => item.block === '3')) {
                        const thirdBlockActRanges = datas
                            .filter(item => item.block === "3")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_3`]);

                        cheerRanges.push({
                            actRanges: thirdBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fourth block
                    if (datas.find(item => item.block === '4')) {
                        const fourthBlockActRanges = datas
                            .filter(item => item.block === "4")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_4`]);

                        cheerRanges.push({
                            actRanges: fourthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fifth block
                    if (datas.find(item => item.block === '5')) {
                        const fifthBlockActRanges = datas
                            .filter(item => item.block === "5")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_5`]);

                        cheerRanges.push({
                            actRanges: fifthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }

                    for (const range of cheerRanges) {
                        const [startCount, endCount] = range.countRange;
                        const [startAct, endAct, cheer] = range.actRanges.find(([start, end]) => msg['c15'] >=
                            startCount && msg['c15'] <= endCount && act5 >= start && act5 <= end) || [];

                        const audioElement = document.getElementById(cheer);


                        if (audioElement) {
                            audioElement.play();
                            break;
                        }

                    }
                } else {
                    document.getElementById("aact5").style.cssText = `height:0%`;
                }
                if (msg['act6'] > 0) {
                    let act6 = Math.min(msg['act6'], 10);
                    let GraphCount1 = (((act6 / 10) * 1.2) * (msg['c16'] / count)) * 100;
                    let GraphCount = Math.min(GraphCount1, 100);

                    document.getElementById("aact6").style.cssText = 'height:' + GraphCount + '%';

                    const stopAllLaughs = Array.from(document.querySelectorAll('[id^="Laugh"]'));
                    stopAllLaughs.forEach(laugh => $.stopAudio(laugh));
                    const data = audios_files.data;
                    const datas = data.filter(item => item.audio_name.startsWith("Laugh"));

                    const laughRanges = [];
                    // First block
                    if (datas.find(item => item.block === '1')) {
                        const firstBlockActRanges = datas
                            .filter(item => item.block === "1")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_1`]);

                        laughRanges.push({
                            actRanges: firstBlockActRanges,
                            countRange: [1, 2]
                        });
                    }

                    // Second block
                    if (datas.find(item => item.block === '2')) {
                        const secondBlockActRanges = datas
                            .filter(item => item.block === "2")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_2`]);

                        laughRanges.push({
                            actRanges: secondBlockActRanges,
                            countRange: [3, 6]
                        });
                    }
                    // third block
                    if (datas.find(item => item.block === '3')) {
                        const thirdBlockActRanges = datas
                            .filter(item => item.block === "3")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_3`]);

                        laughRanges.push({
                            actRanges: thirdBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fourth block
                    if (datas.find(item => item.block === '4')) {
                        const fourthBlockActRanges = datas
                            .filter(item => item.block === "4")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_4`]);

                        laughRanges.push({
                            actRanges: fourthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }
                    // fifth block
                    if (datas.find(item => item.block === '5')) {
                        const fifthBlockActRanges = datas
                            .filter(item => item.block === "5")
                            .map((audio, index) => [(index * 2) + 1, (index * 2) + 2, `${audio.audio_name}_5`]);

                        laughRanges.push({
                            actRanges: fifthBlockActRanges,
                            countRange: [8, 10]
                        });
                    }

                    for (const range of laughRanges) {
                        const [startCount, endCount] = range.countRange;
                        const [startAct, endAct, laugh] = range.actRanges.find(([start, end]) => msg['c16'] >=
                            startCount && msg['c16'] <= endCount && act6 >= start && act6 <= end) || [];

                        const audioElement = document.getElementById(laugh);


                        if (audioElement) {
                            audioElement.play();
                            break;
                        }

                    }
                } else {
                    document.getElementById("aact6").style.cssText = `height:0%`;
                }
            }
            console.log('artist_action_graph_count response: ', msg)
        });
        setInterval(function() {
            document.getElementById("aact1").style.cssText = `height:0%`;
            document.getElementById("aact2").style.cssText = `height:0%`;
            document.getElementById("aact3").style.cssText = `height:0%`;
            document.getElementById("aact4").style.cssText = `height:0%`;
            document.getElementById("aact5").style.cssText = `height:0%`;
            document.getElementById("aact6").style.cssText = `height:0%`;
        }, 6000);
        $.playAudio = function(audiotype) {
            audiotype.play();

        }

        $.stopAudio = function(audiotype) {
            audiotype.pause();
        }
    </script>
@endsection
