'use client';

import { useEffect, useState } from 'react';
import Image from 'next/image';
import { zodResolver } from '@hookform/resolvers/zod';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { useSearchParams } from 'next/navigation';

import { Button } from '@/shared/ui/button';
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/shared/ui/form';
import { Textarea } from '@/shared/ui/textarea';

const formSchema = z.object({
  rating: z.number().min(1, 'Укажите оценку от 1 до 5'),
  comment: z.string().optional(),
});

export function ReviewForm() {
  const searchParams = useSearchParams();
  const clientId = searchParams.get('id');

  const [message, setMessage] = useState<string | null>(null);
  const [isClientValid, setIsClientValid] = useState<boolean | null>(null);
  const [submitted, setSubmitted] = useState(false);
  const [loading, setLoading] = useState(true);

  const form = useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      rating: 0,
      comment: '',
    },
  });

  useEffect(() => {
    if (!clientId) {
      setIsClientValid(false);
      setLoading(false);
      return;
    }

    fetch(
      `${process.env.NEXT_PUBLIC_API_URL}/validate-client.php?id=${clientId}`
    )
      .then((res) => res.json())
      .then((data) => {
        setIsClientValid(data.valid === true);
        setLoading(false);
      })
      .catch(() => {
        setIsClientValid(false);
        setLoading(false);
      });
  }, [clientId]);

  async function onSubmit(values: z.infer<typeof formSchema>) {
    if (!clientId) {
      setIsClientValid(false);
      return;
    }

    try {
      const response = await fetch(
        `${process.env.NEXT_PUBLIC_API_URL}/submit-review.php`,
        {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ ...values, client_id: clientId }),
        }
      );

      if (response.ok) {
        setMessage('Спасибо за ваш отзыв!');
        setSubmitted(true);
      } else {
        setIsClientValid(false);
      }
    } catch {
      setIsClientValid(false);
    }
  }

  if (loading) {
    return (
      <div className="mt-10 flex flex-col items-center text-center text-2xl text-green-500">
        <Image
          src="/good.png"
          alt="Проверка клиента..."
          width={400}
          height={400}
        />
        <p>Проверка клиента...</p>
      </div>
    );
  }

  if (!isClientValid) {
    return (
      <div className="mt-10 flex flex-col items-center text-center text-2xl text-red-500">
        <Image src="/not-found.png" alt="Not found" width={400} height={400} />
        <p>Опрос недоступен</p>
      </div>
    );
  }

  if (submitted) {
    return (
      <div className="mt-10 flex flex-col items-center text-center text-2xl text-green-500">
        <Image src="/accept.png" alt="Отзыв принят" width={400} height={400} />
        <p>Спасибо за отзыв!</p>
      </div>
    );
  }

  return (
    <Form {...form}>
      <form
        onSubmit={form.handleSubmit(onSubmit)}
        className="mx-auto flex flex-col items-center space-y-6"
      >
        <FormField
          control={form.control}
          name="rating"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Оцените качество обслуживания</FormLabel>
              <FormControl>
                <div className="flex gap-2">
                  {[1, 2, 3, 4, 5].map((val) => (
                    <Button
                      key={val}
                      className="h-[2.5rem] w-[2.5rem]"
                      type="button"
                      variant={field.value === val ? 'default' : 'outline'}
                      onClick={() => field.onChange(val)}
                    >
                      {val}
                    </Button>
                  ))}
                </div>
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />

        <FormField
          control={form.control}
          name="comment"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Комментарий (необязательно)</FormLabel>
              <FormControl>
                <Textarea
                  className="min-w-lg"
                  placeholder="Можете оставить комментарий"
                  {...field}
                />
              </FormControl>
              <FormDescription className="text-lg">
                Вы можете поделиться впечатлениями о прошедшем событии!
              </FormDescription>
              <FormMessage />
            </FormItem>
          )}
        />

        <Button className="h-lg w-lg text-lg" type="submit">
          Отправить
        </Button>

        {message && (
          <div className="text-muted-foreground mt-2 text-sm">{message}</div>
        )}
      </form>
    </Form>
  );
}
