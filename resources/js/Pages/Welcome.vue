<template>
    <Head title="Welcome" />

    <Section class="grid grid-cols-2 text-right bg-gray-800 text-gray-300">
        <div>
            <jet-application-mark class="h-12 w-auto"></jet-application-mark>
        </div>
        <div v-if="canLogin">
            <Link
                v-if="$page.props.user"
                :href="route('dashboard')"
                class="text-sm underline"
            >
                Dashboard
            </Link>
            <template v-else>
                <Link :href="route('login')" class="text-base underline">
                    Log in
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="text-base underline place-self-end ml-4"
                >
                    Register
                </Link>
            </template>
        </div>
    </Section>

    <Section class="bg-gray-800 pt-16 h-screen">
        <div class="h-2/3 flex flex-wrap content-between pb-36">
            <p
                class="border-b-2 font-bold border-gray-400 pb-3 text-2xl text-gray-300 uppercase"
            >
                Hey! This is mbnoimi. I'm a Senior Software Engineer and I would
                be glad to work with you.
            </p>
            <div class="flex items-end border-b-2 border-gray-500 pb-2">
                <p class="font-bold mr-5 text-gray-500 text-xl">
                    Want to know more?
                </p>
                <jet-button
                    class="bg-green-400 rounded font-bold hover:bg-green-800 text-sm text-gray-800"
                    @click="contacting = true"
                >
                    {{ $page.props.flash.contacted ? "Thanks!" : "Let's chat" }}
                </jet-button>
            </div>
        </div>
        <div class="animate-pulse mt-3 text-gray-300 text-center text-9xl">
            <a href="#skills"> &#8675; </a>
        </div>
    </Section>

    <Section id="skills" class="bg-gray-200 text-gray-800 h-screen">
        <h2 class="text-6xl font-bold pt-3">Skills</h2>
        <div class="grid grid-cols-2">
            <div v-for="skill in skills">
                <Skill :background="skill.color">
                    {{ skill.name }}
                </Skill>
            </div>
        </div>
        <div class="flex justify-center mt-10">
            <jet-button
                class="bg-indigo-800 rounded font-bold hover:bg-green-800 text-sm text-indigo-200"
                @click="contacting = true"
            >
                {{ $page.props.flash.contacted ? "Thanks!" : "Get in touch" }}
            </jet-button>
        </div>
    </Section>

    <Section class="bg-gray-600 text-gray-200 h-screen">
        <h2 class="text-6xl font-bold pt-3">Projects</h2>
        <div v-for="(project, index) in projects">
            <Project
                :title="project.title"
                :description="project.description"
                :color="project.color"
            >
                <!-- FIXME: Dynamic import doesn't work with Vite! -->
                <!-- <component :is="componentName(index)"></component> -->
                <BeakerIcon></BeakerIcon>
            </Project>
        </div>
        <div class="flex justify-center mt-10">
            <jet-button
                class="bg-indigo-800 rounded font-bold hover:bg-green-800 text-sm text-indigo-200"
                @click="contacting = true"
            >
                {{ $page.props.flash.contacted ? "Thanks!" : "Know more" }}
            </jet-button>
        </div>
    </Section>

    <Section class="flex justify-between bg-gray-800 text-gray-300 text-xl">
        <p>&copy; HPC-TECH. All right reserved.</p>
        <div class="flex justify-evenly items-center">
            <Link class="border-b pb-1 px-2 hover:text-gray-50" href="#"
                >Twitter</Link
            >
            <Link class="border-b pb-1 px-2 hover:text-gray-50" href="#"
                >YouTube</Link
            >
            <Link class="border-b pb-1 px-2 hover:text-gray-50" href="#"
                >Telegram</Link
            >
        </div>
    </Section>
    <jet-modal :show="contacting" closeable="true" @close="contacting = null">
        <div class="bg-gray-50 shadow-2xl p-8">
            <div
                v-if="$page.props.flash.contacted"
                class="bg-green-400 shadow-2xl text-center font-bold p-8"
            >
                <p class="text-8xl m-5">👍</p>
                <p class="text-5xl font-bold m-2">Thanks!</p>
                <p class="text-xl m-2">I'll get back to you soon.</p>
            </div>
            <div v-else class="bg-gray-50 shadow-2xl p-8">
                <p class="text-gray-600 text-2xl font-extrabold text-center">
                    Let me know some details
                </p>
                <form
                    class="flex flex-col items-center p-16"
                    @submit.prevent="submit"
                >
                    <jet-input
                        class="px-5 py-3 w-96 border border-gray-600 rounded"
                        type="email"
                        name="email"
                        placeholder="Your email"
                        v-model="form.email"
                    ></jet-input>

                    <jet-input-error :message="form.errors.email" />

                    <textarea
                        class="px-5 py-3 w-96 border border-gray-600 rounded mt-5"
                        name="message"
                        placeholder="The details :)"
                        v-model="form.message"
                    ></textarea>

                    <jet-input-error :message="form.errors.message" />

                    <jet-button
                        class="px-5 py-3 mt-5 w-96 bg-purple-400 justify-center rounded-xl text-sm"
                        :disabled="form.processing"
                    >
                        <span
                            class="animate-spin mr-1"
                            v-show="form.processing"
                        >
                            &#9696;
                        </span>
                        <span v-show="!form.processing"> Get in touch </span>
                    </jet-button>
                </form>
            </div>
        </div>
    </jet-modal>
</template>
<script>
import { defineComponent, defineAsyncComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetApplicationMark from "@/Components/ApplicationMark.vue";
import JetButton from "@/Components/Button.vue";
import Section from "@/Components/Section.vue";
import Skill from "@/Components/Skill.vue";
import Project from "@/Components/Project.vue";
import { BeakerIcon } from "@heroicons/vue/24/solid";
import JetModal from "@/Components/Modal.vue";
import JetInput from "@/Components/Input.vue";
import JetInputError from "@/Components/InputError.vue";

export default defineComponent({
    components: {
        Head,
        Link,
        JetApplicationMark,
        Section,
        JetButton,
        Skill,
        Project,
        BeakerIcon,
        JetModal,
        JetInput,
        JetInputError,
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        skills: Object,
        projects: Object,
    },

    methods: {
        componentName(index) {
            return defineAsyncComponent(() => {
                import(
                    "@heroicons/vue/24/solid/" +
                        this.projects[index].icon_name +
                        "Icon.js"
                );
            });
        },
        submit() {
            this.form.post(route("contact"));
        },
    },
    data() {
        return {
            contacting: null,
            form: this.$inertia.form({
                email: "",
                message: "",
            }),
        };
    },
});
</script>
