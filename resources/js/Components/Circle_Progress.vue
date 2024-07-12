<template>
    <div>
        <!-- :data-pct="percentage" -->
        <div class="circle__container" id="cont">
            <svg
                id="svg"
                width="200"
                height="200"
                viewPort="0 0 100 100"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
            >
                <circle
                    class="circle-outer"
                    :r="r_value + 9"
                    cx="100"
                    cy="100"
                ></circle>
                <circle
                    class="circle-inner"
                    :r="r_value - 9"
                    cx="100"
                    cy="100"
                ></circle>
                <circle
                    class="circle-stroke"
                    :class="stroke_color"
                    :r="rValue"
                    cx="100"
                    cy="100"
                    fill="transparent"
                    :stroke-dasharray="circle_length"
                    :stroke-dashoffset="strokeDashOffset"
                    :style="{ 'stroke-width': `${stroke_width}rem` }"
                ></circle>
            </svg>
            <p>{{ percentValue }}%</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        rValue: Number,
        percentValue: Number,
        strokeWidth: Number,
    },
    data() {
        return {
            inputValue: this.percentValue,
            percentage: this.percentValue,
            r_value: this.rValue,
            stroke_width: this.strokeWidth,
        };
    },
    computed: {
        strokeDashOffset() {
            let r = this.r_value;
            const c = 2 * Math.PI * r;
            return c - (this.percentage / 100) * c;
        },
        circle_length() {
            return 2 * Math.PI * this.r_value;
        },
        stroke_color() {
            if (this.percentage <= 20) {
                return "red";
            } else if (this.percentage <= 40) {
                return "orange";
            } else if (this.percentage <= 60) {
                return "yellow";
            } else if (this.percentage <= 80) {
                return "blue";
            } else if (this.percentage <= 100) {
                return "green";
            } else {
                return "neutral";
            }
        },
    },
    methods: {
        updateProgress() {
            let val = parseInt(this.inputValue);
            if (isNaN(val)) {
                val = 100;
            } else {
                val = Math.max(0, Math.min(val, 100));
            }
            this.percentage = val;
        },
    },
    watch: {
        percentValue(newVal) {
            if (newVal) {
                this.percentage = newVal;
            }
        },
    },
};
</script>

<style lang="postcss" scoped>
#svg .circle-stroke {
    /* @apply stroke-blue-500; */
    transition: stroke-dashoffset 1s ease;
    /* Rotate the circle to start at the top */
    transform: rotate(-90deg);
    /* Ensure rotation is centered */
    transform-origin: 50% 50%;
}

.circle-inner {
    @apply fill-shades-white;
}

.circle-outer {
    @apply fill-neutral-100;
}

#cont {
    display: block;
    height: 200px;
    width: 200px;
    border-radius: 100%;
    position: relative;
}

.circle__container > p {
    @apply absolute flex justify-center items-center text-base w-full h-full top-0 left-0 z-[1];
}

.red {
    @apply stroke-red-500;
}

.orange {
    @apply stroke-orange-500;
}

.yellow {
    @apply stroke-yellow-500;
}

.blue {
    @apply stroke-blue-500;
}

.green {
    @apply stroke-green-500;
}

.neutral {
    @apply stroke-neutral-200;
}
</style>
