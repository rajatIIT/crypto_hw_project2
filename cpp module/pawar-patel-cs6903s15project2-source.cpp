#include <iostream>
#include <sstream>
#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <openssl/sha.h>
#include <openssl/evp.h>
#include <openssl/aes.h>
#include <openssl/rsa.h>
#include <openssl/pem.h>
#include <openssl/err.h>
#define KEY_LENGTH  2048
#define PUB_EXP     3

using namespace std;

// Method to convert the unsigned char to hex
string to_hex(unsigned char s) {
    stringstream ss;
    ss << hex << (int) s;
    return ss.str();
}

// Method to calculate the SHA256 hash

string sha256(string line) {
    unsigned char hash[SHA256_DIGEST_LENGTH];
    SHA256_CTX sha256;
    SHA256_Init(&sha256);
    SHA256_Update(&sha256, line.c_str(), line.length());
    SHA256_Final(hash, &sha256);
    string output = "";
    for(int i = 0; i < SHA256_DIGEST_LENGTH; i++) {
        output += to_hex(hash[i]);
    }
    return output;
}

// Method to encrypt the file with AES

void encrypt(FILE *ifp, FILE *ofp, unsigned char *ckey, unsigned char *ivec) {
    
    const unsigned BUFSIZE=4096;
    unsigned char *read_buf = (unsigned char *)malloc(BUFSIZE);
    unsigned char *cipher_buf;
    unsigned blocksize;
    int out_len;
    EVP_CIPHER_CTX ctx;
    EVP_CipherInit(&ctx, EVP_aes_256_cbc(), ckey, ivec, 1); // Flag set to 1 to encrypt the file
    blocksize = EVP_CIPHER_CTX_block_size(&ctx);
    cipher_buf = (unsigned char *)malloc(BUFSIZE + blocksize);
    
    while (1) {
        int numRead = fread(read_buf, sizeof(unsigned char), BUFSIZE, ifp);
        EVP_CipherUpdate(&ctx, cipher_buf, &out_len, read_buf, numRead);
        fwrite(cipher_buf, sizeof(unsigned char), out_len, ofp);
        if (numRead < BUFSIZE) {
            break;
        }
    }
    EVP_CipherFinal(&ctx, cipher_buf, &out_len);
    fwrite(cipher_buf, sizeof(unsigned char), out_len, ofp);
    free(cipher_buf);
    free(read_buf);
}


// Method to decrypt the file with AES

void decrypt(FILE *ifp, FILE *ofp, unsigned char *ckey, unsigned char *ivec) {
    
    const unsigned BUFSIZE=4096;
    unsigned char *read_buf = (unsigned char *)malloc(BUFSIZE);
    unsigned char *cipher_buf;
    unsigned blocksize;
    int out_len;
    EVP_CIPHER_CTX ctx;
    
    EVP_CipherInit(&ctx, EVP_aes_256_cbc(), ckey, ivec, 0); // Flag set to 0 to decrypt the file
    blocksize = EVP_CIPHER_CTX_block_size(&ctx);
    cipher_buf = (unsigned char *)malloc(BUFSIZE + blocksize);
    
    while (1) {
        int numRead = fread(read_buf, sizeof(unsigned char), BUFSIZE, ifp);
        EVP_CipherUpdate(&ctx, cipher_buf, &out_len, read_buf, numRead);
        fwrite(cipher_buf, sizeof(unsigned char), out_len, ofp);
        if (numRead < BUFSIZE) {
            break;
        }
    }
    EVP_CipherFinal(&ctx, cipher_buf, &out_len);
    fwrite(cipher_buf, sizeof(unsigned char), out_len, ofp);
    free(cipher_buf);
    free(read_buf);
}

void aes_call(){
    
    unsigned char ckey[] = "privatekeygoeshere";
    unsigned char ivec[] = "initializationvectorgoeshere";
    FILE *fIN, *fOUT;
    
    string file_name;
    cout<<"Enter the file name to encrypt : ";
    cin>>file_name;
    // First encrypt the file
    string encrypt_file_name=file_name+"_enc";
    string decrypt_file_name=file_name+"_dec";
    fIN = fopen(file_name.c_str(), "rb"); //File to be encrypted; plain text
    fOUT = fopen(encrypt_file_name.c_str(), "wb"); //File to be written; cipher text
    
    encrypt(fIN, fOUT, ckey, ivec);
    cout<<"Encrypted file generated : "<<encrypt_file_name<<endl;
    fclose(fIN);
    fclose(fOUT);
    
    //Decrypt file now
    
    fIN = fopen(encrypt_file_name.c_str(), "rb"); //File to be read; cipher text
    fOUT = fopen(decrypt_file_name.c_str(), "wb"); //File to be written; plain text
    
    decrypt(fIN, fOUT, ckey, ivec);
    cout<<"File decrypted : "<<decrypt_file_name<<endl;
    fclose(fIN);
    fclose(fOUT);

}

void rsa_call(){

    size_t pri_len;            // Length of private key
    size_t pub_len;            // Length of public key
    char   *pri_key;           // Private key
    char   *pub_key;           // Public key
    //char   msg[KEY_LENGTH/8];  // Message to encrypt
    char   *encrypt = NULL;    // Encrypted message
    char   *decrypt = NULL;    // Decrypted message
    char   *err;               // Buffer for any error messages
    
    // Generate key pair
    printf("Generating RSA (%d bits) keypair...", KEY_LENGTH);
    fflush(stdout);
    RSA *keypair = RSA_generate_key(KEY_LENGTH, PUB_EXP, NULL, NULL);
    
    // To get the C-string PEM form:
    BIO *pri = BIO_new(BIO_s_mem());
    BIO *pub = BIO_new(BIO_s_mem());
    
    PEM_write_bio_RSAPrivateKey(pri, keypair, NULL, NULL, 0, NULL, NULL);
    PEM_write_bio_RSAPublicKey(pub, keypair);
    
    pri_len = BIO_pending(pri);
    pub_len = BIO_pending(pub);
    
    pri_key = (char *)malloc(pri_len + 1);
    pub_key = (char *)malloc(pub_len + 1);
    
    BIO_read(pri, pri_key, pri_len);
    BIO_read(pub, pub_key, pub_len);
    
    pri_key[pri_len] = '\0';
    pub_key[pub_len] = '\0';
    
    cout<<"\n"<<pri_key<<"\n"<<pub_key<<endl;

    // Get the message to encrypt
    string msg;
    cout<<"Message to encrypt: ";
    //fgets(msg, KEY_LENGTH-1, stdin);
    cin>>msg;//msg[strlen(msg)-1] = '\0';
    
    // Encrypt the message
    encrypt = (char *)malloc(RSA_size(keypair));
    int encrypt_len;
    err = (char *)malloc(130);
    FILE *out = fopen("out.bin", "w");
    if((encrypt_len = RSA_public_encrypt(msg.length()+1, (unsigned char*)msg.c_str(), (unsigned char*)encrypt,
                                         keypair, RSA_PKCS1_OAEP_PADDING)) == -1) {
        ERR_load_crypto_strings();
        ERR_error_string(ERR_get_error(), err);
        fprintf(stderr, "Error encrypting message: %s\n", err);
        goto free_stuff;
    }
    

    // Write the encrypted message to a file
    
    fwrite(encrypt, sizeof(*encrypt),  RSA_size(keypair), out);
    fclose(out);
    printf("Encrypted message written to file.\n");
    free(encrypt);
    encrypt = NULL;
    
    // Read it back
    printf("Reading back encrypted message and attempting decryption...\n");
    encrypt = (char *)malloc(RSA_size(keypair));
    out = fopen("out.bin", "r");
    fread(encrypt, sizeof(*encrypt), RSA_size(keypair), out);
    fclose(out);
    
    // Decrypt it
    decrypt = (char *)malloc(encrypt_len);
    if(RSA_private_decrypt(encrypt_len, (unsigned char*)encrypt, (unsigned char*)decrypt,
                           keypair, RSA_PKCS1_OAEP_PADDING) == -1) {
        ERR_load_crypto_strings();
        ERR_error_string(ERR_get_error(), err);
        fprintf(stderr, "Error decrypting message: %s\n", err);
        goto free_stuff;
    }
    printf("Decrypted message: %s\n", decrypt);
    
free_stuff:
    RSA_free(keypair);
    BIO_free_all(pub);
    BIO_free_all(pri);
    free(pri_key);
    free(pub_key);
    free(encrypt);
    free(decrypt);
    free(err);
    
    
}
int main() {
    
    string userInput;
    int input;
    while(true){
        cout<<"1. SHA256 calculate"<<endl;
        cout<<"2. AES encryption"<<endl;
        cout<<"3. RSA encryption"<<endl;
        cout<<"4. Exit"<<endl<<endl;
        cout<<"Enter choice to perform the action : ";
        cin>>input;
        if (input==4) {
            break;
        }
        switch (input) {
            case 1:
                cout<<"Enter a message to find the SHA256 hash : ";
                cin>>userInput;
                cout << sha256(userInput) << endl;
                break;
            case 2:
                aes_call();
                break;
            case 3:
                rsa_call();
                break;
            default:
                cout<<"Invalid input. Try again.";
                break;
        }
        
    }
    return 0;
}