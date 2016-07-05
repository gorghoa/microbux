docker run \
        --name weasley_reducer \
        --rm  \
        -e REDUCER_NAME=weasleys \
        -e MICROBUX_STORE=http://store:8000 \
        -v `pwd`:/app \
        --net microbux_default \
        --link microbux_store_1:store \
        reducer
