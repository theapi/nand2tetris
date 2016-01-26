//** push constant 0 **//
// constant
@0
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** pop local 0 **//
// local
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@LCL   // set address to LCL
A=M   // use the value stored in LCL as the next address
M=D   // store the value at the address


//** label LOOP_START **//
// writeLabel LOOP_START
(LOOP_START)


//** push argument 0 **//
// argument
@0
D=A       // Store the index value in D
@ARG   // set address to ARG
A=D+M     // set the address to be ARG + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** push local 0 **//
// local
@0
D=A       // Store the index value in D
@LCL   // set address to LCL
A=D+M     // set the address to be LCL + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** add **//
//    add
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=D+M  // x+y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** pop local 0 **//
// local
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@LCL   // set address to LCL
A=M   // use the value stored in LCL as the next address
M=D   // store the value at the address


//** push argument 0 **//
// argument
@0
D=A       // Store the index value in D
@ARG   // set address to ARG
A=D+M     // set the address to be ARG + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** push constant 1 **//
// constant
@1
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** sub **//
//    sub
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M-D  // x-y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** pop argument 0 **//
// argument
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@ARG   // set address to ARG
A=M   // use the value stored in ARG as the next address
M=D   // store the value at the address


//** push argument 0 **//
// argument
@0
D=A       // Store the index value in D
@ARG   // set address to ARG
A=D+M     // set the address to be ARG + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


//** if-goto LOOP_START **//
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@LOOP_START
D;JNE


//** push local 0 **//
// local
@0
D=A       // Store the index value in D
@LCL   // set address to LCL
A=D+M     // set the address to be LCL + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


