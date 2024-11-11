<template>
    <div class="flex flex-col items-center pt-9 pl-20 bg-black pb-[1102px] max-md:pb-24 max-md:pl-5">
      <header class="flex flex-wrap gap-10 justify-center items-center font-semibold max-md:max-w-full">
        <div class="flex flex-col justify-center items-start self-stretch px-3.5 py-7 my-auto text-3xl whitespace-nowrap bg-black bg-opacity-0 min-w-[240px] text-neutral-200 w-[906px] max-md:pr-5 max-md:max-w-full">
          <h1 class="gap-10 self-stretch max-w-full w-[136px]">Eventive</h1>
        </div>
        <nav class="flex gap-4 justify-center items-center self-stretch my-auto text-sm text-neutral-300">
          <button class="flex gap-4 justify-center items-center self-stretch px-2 my-auto w-24 whitespace-nowrap rounded-xl border border-solid shadow-sm bg-stone-950 border-stone-900 min-h-[42px]">
            <span class="gap-2.5 self-stretch p-2.5 my-auto">Login</span>
          </button>
          <button class="flex gap-2 justify-center items-center self-stretch px-5 py-1 my-auto rounded-xl shadow-lg bg-fuchsia-950">
            <span class="gap-2.5 self-stretch p-2.5 my-auto">Sign up</span>
          </button>
        </nav>
      </header>
      <section class="flex relative flex-col items-start self-end mt-12 max-w-full text-6xl font-bold text-white min-h-[370px] w-[1577px] max-md:pr-5 max-md:mt-10 max-md:text-4xl">
        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/9201ea9adba7de7bb1f830dd8156941f2dbc6cb2e1cf02d30cf1e3eb3cf9b49b?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-cover absolute inset-0 size-full" />
        <div class="flex relative z-10 flex-col px-16 pt-16 pb-36 -mt-8 mb-0 rounded-2xl max-w-[708px] min-h-[480px] max-md:px-5 max-md:pb-28 max-md:mb-2.5 max-md:max-w-full max-md:text-4xl">
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/330b9402c0ea7f33a2faaea254ed4068b28b370abce6dbd9afaf24801fb0d4f8?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-cover absolute inset-0 size-full" />
          <h2>MADE FOR<br />THOSE <br />WHO DO</h2>
        </div>
      </section>
      <form class="flex z-10 flex-wrap gap-10 justify-center items-center px-10 py-11 mt-0 rounded-xl bg-neutral-900 max-md:px-5 max-md:max-w-full">
        <div class="flex flex-wrap gap-10 items-center self-stretch px-1.5 my-auto text-white min-w-[240px] max-md:max-w-full">
          <div class="flex relative flex-col justify-center self-stretch my-auto w-[210px]">
            <label for="lookingFor" class="z-0 text-sm font-medium">Looking for</label>
            <div class="flex z-0 flex-col mt-6 w-full text-xl font-semibold">
              <input id="lookingFor" type="text" value="Hassan Efed Tour" class="bg-transparent border-b border-white" />
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/1d5aff3c08345df1c0357ac807ffdc919d35d32728e63c5c27278f5e6848d765?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-contain mt-3 max-w-full aspect-[250] w-[252px]" />
            </div>
            <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/34c0240e1dd27c63e2dfdb1f75b5e6e6559a7f902da4785f82ac0e54cf57e51e?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-contain absolute bottom-1 z-0 w-7 h-7 aspect-square right-[-809px]" />
          </div>
          <div class="flex flex-col justify-center self-stretch my-auto whitespace-nowrap w-[210px]">
            <label for="location" class="text-sm font-medium">In</label>
            <div class="flex flex-col mt-6 w-full text-xl font-semibold">
              <input id="location" type="text" value="Marrakech" class="bg-transparent border-b border-white" />
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/1d5aff3c08345df1c0357ac807ffdc919d35d32728e63c5c27278f5e6848d765?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-contain mt-3 max-w-full aspect-[250] w-[252px]" />
            </div>
          </div>
          <div class="flex flex-col justify-center self-stretch my-auto w-[210px]">
            <label for="date" class="text-sm font-medium">When</label>
            <div class="flex flex-col mt-6 w-full text-xl font-semibold">
              <input id="date" type="text" value="Any Date" class="bg-transparent border-b border-white" />
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/1d5aff3c08345df1c0357ac807ffdc919d35d32728e63c5c27278f5e6848d765?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-contain mt-3 max-w-full aspect-[250] w-[252px]" />
            </div>
          </div>
        </div>
        <button type="submit" class="flex gap-2 justify-center items-center self-stretch px-3 my-auto rounded-xl shadow-lg bg-fuchsia-950 h-[65px] w-[65px]">
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/2015fb2e0a4590955e87596ac86ffc50dff6da91f021e34a017e9de9fbdb3957?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="Search" class="object-contain self-stretch my-auto aspect-square shadow-[0px_4px_4px_rgba(0,0,0,0.25)] w-[41px]" />
        </button>
      </form>
      <section class="flex flex-wrap gap-10 justify-center items-center mt-40 w-full font-semibold text-white max-w-[1480px] max-md:mt-10 max-md:max-w-full">
        <h2 class="gap-2.5 self-stretch p-2.5 my-auto text-5xl min-w-[240px] max-md:max-w-full max-md:text-4xl">Upcoming Events</h2>
        <div class="flex flex-wrap grow shrink gap-8 justify-between items-center self-stretch px-28 my-auto text-base min-w-[240px] w-[571px] max-md:px-5 max-md:max-w-full">
          <button class="flex gap-2.5 justify-center items-center self-stretch px-8 py-6 my-auto rounded-lg bg-neutral-900 max-md:px-5">
            <span class="flex gap-5 items-center self-stretch my-auto">
              Event Type
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b9179e1a7202df780e436a5a9ac6ae22d16f462e3307dd8496f247f12ba721c6?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-contain shrink-0 self-stretch my-auto aspect-square w-[25px]" />
            </span>
          </button>
          <button class="flex gap-2.5 justify-center items-center self-stretch px-8 py-6 my-auto rounded-lg bg-neutral-900 max-md:px-5">
            <span class="flex gap-5 items-center self-stretch my-auto">
              Any Category
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b9179e1a7202df780e436a5a9ac6ae22d16f462e3307dd8496f247f12ba721c6?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="" class="object-contain shrink-0 self-stretch my-auto aspect-square w-[25px]" />
            </span>
          </button>
        </div>
      </section>
      <article class="flex relative gap-10 justify-between items-start px-5 pt-10 pb-16 mt-24 w-full bg-black rounded-xl shadow-sm max-w-[1191px] max-md:mt-10 max-md:max-w-full">
        <div class="flex z-0 flex-col justify-center items-end self-stretch my-auto w-[89px]">
          <div class="flex flex-col w-full max-w-[89px]">
            <div class="flex relative gap-7 items-start">
              <div class="flex z-0 shrink-0 bg-violet-200 h-[126px] w-[89px]"></div>
              <div class="flex absolute right-0 bottom-0 z-0 shrink-0 shadow-lg bg-fuchsia-950 h-[35px] w-[89px]"></div>
              <time datetime="19:00" class="absolute bottom-2.5 left-3.5 z-0 h-4 text-sm font-medium text-white w-[60px]">7:00 PM</time>
              <div class="flex absolute top-2 z-0 flex-col justify-center items-center font-medium text-purple-900 whitespace-nowrap right-[11px] w-[67px]">
                <span class="text-base">JUNE</span>
                <span class="text-4xl">27</span>
                <span class="text-sm">2024</span>
              </div>
              <div class="flex absolute top-0 z-0 flex-col justify-center min-w-[240px] right-[-370px]">
                <div class="flex flex-col">
                  <span class="text-base text-stone-300">COMEDY</span>
                  <div class="flex flex-col">
                    <h3 class="text-4xl font-semibold text-stone-300">Hassan Elfed Show</h3>
                    <p class="mt-2 text-xl text-white">Check tour- 2022</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex absolute z-0 gap-9 items-center text-base text-center text-white bottom-[18px] left-[177px] min-w-[240px]">
          <button class="flex-1 shrink gap-2 self-stretch py-3 my-auto rounded-sm shadow-lg bg-fuchsia-950 min-h-[42px] w-[147px]">Get Ticket</button>
          <button class="flex-1 shrink gap-2 self-stretch py-3 my-auto rounded-md shadow-lg min-h-[42px] w-[149px]">View Details</button>
        </div>
        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b3c84b84f57e89058dd9af51c3d312b635a41c6f8e8e5e2d1f2b9ff72078875a?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="Event image" class="object-contain absolute z-0 rounded-xl aspect-[2] h-[199px] min-w-[240px] right-[18px] top-[17px] w-[399px]" />
      </article>
      <article class="flex relative gap-10 justify-between items-start px-5 pt-10 pb-16 w-full bg-black rounded-xl shadow-sm max-md:max-w-full">
        <div class="flex z-0 flex-col justify-center items-end self-stretch my-auto w-[89px]">
          <div class="flex flex-col w-full max-w-[89px]">
            <div class="flex relative gap-7 items-start">
              <div class="flex z-0 shrink-0 bg-violet-200 h-[126px] w-[89px]"></div>
              <div class="flex absolute right-0 bottom-0 z-0 shrink-0 shadow-lg bg-fuchsia-950 h-[35px] w-[89px]"></div>
              <time datetime="19:00" class="absolute bottom-2.5 left-3.5 z-0 h-4 text-sm font-medium text-white w-[60px]">7:00 PM</time>
              <div class="flex absolute top-2 z-0 flex-col justify-center items-center font-medium text-purple-900 whitespace-nowrap right-[11px] w-[67px]">
                <span class="text-base">JUNE</span>
                <span class="text-4xl">27</span>
                <span class="text-sm">2024</span>
              </div>
              <div class="flex absolute top-0 z-0 flex-col justify-center min-w-[240px] right-[-370px]">
                <div class="flex flex-col">
                  <span class="text-base text-stone-300">COMEDY</span>
                  <div class="flex flex-col">
                    <h3 class="text-4xl font-semibold text-stone-300">Hassan Elfed Show</h3>
                    <p class="mt-2 text-xl text-white">Check tour- 2022</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex absolute z-0 gap-9 items-center text-base text-center text-white bottom-[18px] left-[177px] min-w-[240px]">
          <button class="flex-1 shrink gap-2 self-stretch py-3 my-auto rounded-sm shadow-lg bg-fuchsia-950 min-h-[42px] w-[147px]">Get Ticket</button>
          <button class="flex-1 shrink gap-2 self-stretch py-3 my-auto rounded-md shadow-lg min-h-[42px] w-[149px]">View Details</button>
        </div>
        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b3c84b84f57e89058dd9af51c3d312b635a41c6f8e8e5e2d1f2b9ff72078875a?placeholderIfAbsent=true&apiKey=4e53a3fa8bb04bc1ba6e0d4cc67e05f7" alt="Event image" class="object-contain absolute z-0 rounded-xl aspect-[2] h-[199px] min-w-[240px] right-[18px] top-[17px] w-[399px]" />
      </article>
    </div>
  </template>
  
  <script>
  export default {
    name: 'EventiveHomepage',
    // Component logic goes here
  }
  </script>